<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Ricerca utenze - Risposta</title>
<?php 
require_once('./req.php');
?> 

</head>

<body>


      <div class="container">


<?php 

if (isset($_POST)){

if ($_POST['submit']) {
     //Save File        

    //echo "sono qua<br>";
    $mail = $_POST['mail'];
    
    $zona = $_POST['zona'];
    //echo $zona.'<br>';

    
    $consegne=$_POST['consegne'];
    if ($consegne=='cons'){
      $cons=1; 
    } else {
      $cons=0;
    }
    
    //echo $consegne;
    //echo $cons;
    //echo "<br>sono qua 2<br>";
    //exit;

    $file = fopen('./file/elenco_vie.txt',"w+");
    $text = $_POST["lista_vie"];
    fwrite($file, $text);
    fclose($file);

    $comando='/usr/bin/python3 /home/procedure/script_sit_amiu/seleziona_utenze_vie.py -i /var/www/html/utenze/file/elenco_vie.txt -m '.$mail.'  -p '. $zona.'  -c '. $cons.'  /dev/null 2>&1 &';
    //echo $comando;
    //echo '<br><br>';
    $output=null;
    $retval=null;
    
    exec($comando, $output, $retval);
    foreach($output as $key => $value)
    {
      echo $key." ".$value."<br>";
    }
    //echo 'RET= '. $retval .'<br>';
    //echo "Returned with status $retval and output:\n";
    //print_r($output);
    #exit();
    if ($retval == 0) {
        //echo 'OK<br>';
      
     


            echo "<h3>Grazie, entro alcuni minuti riceverai i dati richiesti alla mail <font color=\"blue\"> ". $mail . "</font> che hai indicato sul form. 
            In caso di problemi ti invitiamo a contattare il gruppo GETE via mail (assterritorio@amiu.genova.it) 
            o telefonicamente al 010 55 84496 / 84728</h3>
            <a href=\"index.php\" class=\"btn btn-info\">Torna alla pagina principale</a>
            ";
            
   
      

    } else {
      echo "KO";
      echo $comando;
      echo "C'è un problema con l'invio dei dati ti invitiamo a contattare il gruppo GETE via mail (assterritorio@amiu.genova.it) 
            o telefonicamente al 010 55 84496 ";
    }
 }

}
require_once('./req_bottom.php');
?>

</div>
</body>

</html>