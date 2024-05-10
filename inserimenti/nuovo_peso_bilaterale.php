<?php

session_start();


require_once('../conn.php');

$m=$_GET["m"];
$s=$_GET["s"];
$d=$_GET["d"];
$dd=$_GET["dd"];
$p=$_GET["p"];


echo $m;
echo "<br>";
echo $s;
echo "<br>";


$query="INSERT INTO UNIOPE.TB_PESI_BILATERALE_MANUALE
(SPORTELLO, ID_SERVIZIO, DATA_CONFERIMENTO, PESO, DESTINAZIONE, DATA_INSERIMENTO, ORA_CONFERIMENTO, REC_ID)
VALUES(:sportello, :servizio, TO_DATE(:data_conf,'YYYY-MM-DD'), :peso, :destinazione, SYSDATE, '00:00:00',
(SELECT max(REC_ID)+1 FROM UNIOPE.TB_PESI_BILATERALE_MANUALE))"; 
echo $query;
//exit;

$compiled = oci_parse($oraconn, $query);

oci_bind_by_name($compiled, ':sportello', $m);
oci_bind_by_name($compiled, ':servizio', $s);
oci_bind_by_name($compiled, ':data_conf', $dd);
oci_bind_by_name($compiled, ':peso', $p);
oci_bind_by_name($compiled, ':destinazione', $d);

oci_execute($compiled);


#$result = pg_query($conn, $query);
echo "<br>";





//exit;




exit;
header("location: ../pesi_bilaterale.php");


?>