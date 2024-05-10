<?php
#session_start();
#require('../validate_input.php');

require ('../conn.php');

//echo "OK";


//$idcivico=$_GET["id"];
$query='SELECT "CHECK", PROVENIENZE, SPORTELLI, CODICE_CER, RIFIUTO, TO_CHAR("DATA", \'yyyy-mm-dd\') as "DATA", ORA, PESO, DESTINAZIONI, REC_ID
FROM UNIOPE.V_PESI_BILATERALI_RAGGRUPPATI ORDER BY "DATA" DESC';


$result = oci_parse($oraconn, $query);
oci_execute($result);
//echo $query;



$rows = array();
while($r = oci_fetch_assoc($result)) {
    $rows[] = $r;
}

#echo "<br>OK";


#echo $rows ;
if (empty($rows)==FALSE){
    //print $rows;
    $locations =(json_encode($rows));
    echo $locations;
} else {
    echo "[{\"NOTE\":'No data'}]";
}

oci_free_statement($result);
oci_close($oraconn);
?>