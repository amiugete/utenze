<?php

//$id=pg_escape_string($_GET['id']);

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Ricerca utenze</title>
<?php 
require_once('./req.php');
require_once('./conn.php');
?> 

</head>

<body>


      <div class="container">
      

            <h2> Utenze ecopunti <i class="fas fa-users"></i> </h2>
            <hr>
            <h4> Il presente form va lanciato dopo aver inserito tutte le utenze degli ecopunti dentro la tabella base_ecopunti dello schema alberghi.
              <font color="red">  NOTA BENE: L'eventuale utilizzo di tale pagina senza aver precedentemente popolato tale tabella produrrà 
                  risoltati assolutamente privi di significato. </font>
            </h4>
            <!--form name="openfile" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'] ?>" -->
            <form name="openfile" method="post" autocomplete="off" action="output_ecopunti.php" >

            <div class="row">
                
            
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="mail">Email address</label><font color="red">*</font>
                <input type="email" class="form-control" id="mail" name= mail  aria-describedby="emailHelp" placeholder="Enter email" required>
            <small class="form-text text-muted">Specificare l'indirizzo e-mail a cui ricevere i risultati.</small>
            </div>
            </div>
            </div>
            <div class="row">

            <div class="form-group  ">
            <input type="submit" name="submit" id=submit class="btn btn-info" value="Recupera utenze ecopunti">
            </div>
            </form>


</div>


</div>

<?php
require_once('req_bottom.php');
require('./footer.php');
?>


</body>

</html>