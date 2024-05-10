<?php

session_start();


require_once('../conn.php');

$id=$_GET["id"];

echo $id;
echo "<br>";



$query="DELETE FROM UNIOPE.TB_PESI_BILATERALE_MANUALE
WHERE REC_ID = :recid"; 
//echo $query;
//exit;

$compiled = oci_parse($oraconn, $query);

oci_bind_by_name($compiled, ':recid', $id);

oci_execute($compiled);


#$result = pg_query($conn, $query);
//echo "<br>";





//exit;




exit;
//header("location: ../pesi_bilaterale.php");


?>