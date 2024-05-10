<?php
session_start();
#require('../validate_input.php');

require ('../conn.php');

//echo "OK";
$mat=$_GET["m"];
$dep=$_GET["d"];
$num=$_GET["n"];
$riemp=$_GET["r"];
$quartieri = $_GET["q"];

$qq=explode(',', $quartieri);

$len=count($qq);
//echo $len."<br>";

if ($mat==''){
    echo "[{\"ID\":'No data'}]";
    exit;
}

$query_truncate="TRUNCATE TABLE \"input\".punti";
$result = pg_prepare($conn_routing, "my_query1", $query_truncate);
$result = pg_execute($conn_routing, "my_query1", array());

//$idcivico=$_GET["id"];
$query="select id, id_piazzola, indirizzo_idea, indirizzo_amiu, 
num, vol, trunc(riempimento_medio) as riempimento_medio, aggiornamenti, lat, lon, geom 
from (
select row_number() over() as id, ci.id_piazzola, 
ci.indirizzo_idea, concat(vpd.via,' ', vpd.civ, ' - ', vpd.riferimento) as indirizzo_amiu,
count(ci.id_elemento_idea) as num, sum(ci.volume_contenitore) as vol, avg(ci.val_riemp) as riempimento_medio,
to_timestamp(avg(extract(epoch from ci.data_ultimo_agg at time zone 'Europe/Rome')))::timestamp as aggiornamenti,
st_x(st_transform(ci.geoloc,4326)) as lon, 
st_y(st_transform(ci.geoloc,4326)) as lat,
st_transform(ci.geoloc,4326) as geom
from idea.censimento_idea ci 
left join elem.v_piazzole_dwh vpd on vpd.id_piazzola::text  = ci.id_piazzola
join geo.quartieri_area qa on qa.id IN (";
$i=1;
foreach ($qq as &$value) {
  if ($i==1){
    $query=$query." $".$i;
  } else {
    $query=$query." , $".$i;
  }
    $i=$i+1;
}
$query=$query.") and st_intersects(ci.geoloc,qa.geoloc)
where ci.cod_cer_mat = $".$i."
group by ci.id_piazzola, ci.geoloc, ci.indirizzo_idea, vpd.via, vpd.civ, vpd.riferimento
) foo";
$i=$i+1;
$query=$query." where riempimento_medio > $".$i;

$i=$i+1;
$query=$query." order by riempimento_medio desc limit $".$i;



//print($query);


//echo "<br>";

//echo $query."<br>";
// Prepare a query for execution
$result0 = pg_prepare($conn, "my_query0", $query);

// Execute the prepared query.  Note that it is not necessary to escape
// the string "Joe's Widgets" in any way
$parameters=array();
foreach ($qq as &$value) {
  array_push($parameters, $value);
}
array_push($parameters, $mat, $riemp, $num);
//print_r($parameters);
//echo "<br>";
$result0 = pg_execute($conn, "my_query0", $parameters);


while($r = pg_fetch_assoc($result0)) {
    //echo $r["id"]."<br>";
    $query_insert='INSERT INTO input.punti
    (id, id_piazzola, indirizzo_idea, indirizzo_amiu, num, vol, riempimento_medio, aggiornamenti, lon, lat, geom)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11);';
    //echo "Ok<br>";
    $result = pg_prepare($conn_routing, "my_query2", $query_insert);
    //echo "Ok1<br>";
    $result = pg_execute($conn_routing, "my_query2", array($r["id"], $r["id_piazzola"], $r["indirizzo_idea"], $r["indirizzo_amiu"],$r["num"], $r["vol"], $r["riempimento_medio"], $r["aggiornamenti"], $r["lon"], $r["lat"], $r["geom"]));
    //echo "Ok2<br>";

}

// insert deposito
$query_insert="INSERT INTO \"input\".punti (SELECT * FROM \"input\".depositi WHERE id=$1);";
$result3 = pg_prepare($conn_routing, "my_query3", $query_insert);
$result3 = pg_execute($conn_routing, "my_query3", array($dep));




// faccio il select di PGROUTING
require_once('query_pgrouting.php');

//echo $query_pgrouting."<br>";
$result4 = pg_prepare($conn_routing, "my_query4", $query_pgrouting);
$result4 = pg_execute($conn_routing, "my_query4", array());

$string_google='https://www.google.com/maps/dir/?api=1&origin=44.4316351,8.9601801&destination=44.4316351,8.9601801&waypoints=';
$rows = array();
while($r4 = pg_fetch_assoc($result4)) {
    $rows[] = $r4;
    $string_google=$string_google."|".round($r4['lat'],6).','.round($r4['lon'],6);
}
$_SESSION['waypoints']=$string_google;
#echo "<br>OK";


#echo $rows ;
if (empty($rows)==FALSE){
    //print $rows;
    $locations =(json_encode($rows));
    //echo $locations;
    $fp = fopen('../results.json', 'w');
    fwrite($fp, json_encode($rows, JSON_PRETTY_PRINT));
    fclose($fp);
    $fp = fopen('../google.txt', 'w');
    fwrite($fp, $string_google);
    fclose($fp);
} else {
    //echo "[{\"NOTE\":'No data'}]";
    $fp = fopen('../results.json', 'w');
    fwrite($fp, "[{\"NOTE\":'No data'}]");
    fclose($fp);
    $fp = fopen('../google.txt', 'w');
    fwrite($fp, "");
    fclose($fp);
}

oci_free_statement($result);
oci_close($oraconn);
?>