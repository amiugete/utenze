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
require_once('./conn.php');
?> 

</head>

<body>


      <div class="container">


<?php 

if (isset($_POST)){

if ($_POST['submit']) {
     //Save File        


    $mail = $_POST['mail'];
    $eco = $_POST['eco'];

    #echo $eco;
    #exit;
    # popolo la tabella base_ecopunti

    # pulisco la tabella
    $query0="TRUNCATE TABLE etl.base_ecopunti CONTINUE IDENTITY RESTRICT;";
    #$result0 = pg_prepare($conn, "my_query0", $query0);
    #$result0 = pg_execute($conn, "my_query0", array());
    $result0 = pg_query($conn, $query0);

    if (!$result0) {
        echo "An error occurred.\n";
        exit;
    }

    # la popolo con i dati dei civici neri
    $query1="insert into etl.base_ecopunti 
(id, geom, cod_strada, numero, lettera, colore, testo, cod_civico, ins_date, mod_date)
select n.* from geo.civici_neri n, etl.aree a 
where a.id=$1 and st_intersects(n.geoloc, a.geom);";
    $result1 = pg_prepare($conn, "my_query1", $query1);
    $result1 = pg_execute($conn, "my_query1", array($eco,));

    # la popolo con i dati dei civici rossi
    $query2="insert into etl.base_ecopunti 
(id, geom, cod_strada, numero, lettera, colore, testo, cod_civico, ins_date, mod_date)
select n.* from geo.civici_rossi n, etl.aree a 
where a.id=$1 and st_intersects(n.geoloc, a.geom);";
    $result2 = pg_prepare($conn, "my_query2", $query2);
    $result2 = pg_execute($conn, "my_query2", array($eco,));

    #$file = fopen('./file/elenco_vie.txt',"w+");
    #$text = $_POST["lista_vie"];
    #fwrite($file, $text);
    #fclose($file);

    



    $comando='/usr/bin/python3 /home/procedure/script_sit_amiu/ecopunti_parte2.py  -m '.$mail.' -a '.$eco.' -e false > /dev/null 2>&1 &';
    #echo $comando;
    #echo '<br><br>';
    exec($comando, $output, $retval);
    foreach($output as $key => $value)
    {
      echo $key." ".$value."<br>";
    }

    if ($retval == 0) {
        //echo 'OK<br>';
      
     


            echo "<h3>Grazie, entro alcuni minuti riceverai i dati richiesti alla mail <font color=\"blue\"> ". $mail . "</font> che hai indicato sul form. 
            In caso di problemi ti invitiamo a contattare il gruppo GETE via mail (assterritorio@amiu.genova.it) 
            o telefonicamente al 010 55 84496 / 84728</h3>
            <a href=\"index_aree.php\" class=\"btn btn-info\">Torna alla pagina principale</a>
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