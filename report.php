<?php

$id=pg_escape_string($_GET['cod']);



?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Report settimanale percorso</title>
<?php 
require_once('./req.php');
require_once('./conn.php');
?> 

</head>

<body>


<?php




$output=null;
$retval=null;
$comando='/usr/bin/python3 /home/procedure/script_sit_amiu/report_settimanali.py '.$id.'';
#echo $comando;
#echo '<br><br>';
exec($comando, $output, $retval);
if ($retval == 0) {
  // define file $mime type here
 
  
  
  $file_name = '/home/procedure/script_sit_amiu/report/report_'.$id.'.xlsx';
  
  // first, get MIME information from the file
  $finfo = finfo_open(FILEINFO_MIME_TYPE); 
  $mime =  finfo_file($finfo, $file_name);
  finfo_close($finfo);

  // send header information to browser
  header('Content-Type: '.$mime);
  header('Content-Disposition: attachment;  filename="report_'.$id.'.xlsx"');
  header('Content-Length: ' . filesize($file_name));
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

  //stream file
  ob_get_clean();
  echo file_get_contents($file_name);
  ob_end_flush();


 
} else {
    echo "Codice errore $retval <br>Verificare che il percorso con id $id sia presente su SIT. <br>Se il problema sussiste contattare $problemi <br><br><br>";
} 
?>
           


</div>


</div>

<?php
require_once('req_bottom.php');
require('./footer.php');
?>











</body>

</html>