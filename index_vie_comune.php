<?php

$id_comune=pg_escape_string($_GET['c']);

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

$query1="SELECT descr_comune FROM topo.comuni WHERE id_comune=$1;";
$result1 = pg_prepare($conn, "my_query1", $query1);
$result1 = pg_execute($conn, "my_query1", array($id_comune));
while($r1 = pg_fetch_assoc($result1)) { 
    $comune =  $r1['descr_comune'];
}
?> 

</head>

<body>

<div class="banner"> <div id="banner-image"></div> </div>
      <div class="container">
      

            <h2> Seleziona vie da cui recuperare le utenze <i class="fas fa-users"></i>  comune di  <?php echo $comune?> </h2>
            <hr>
            <!--form name="openfile" method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'] ?>" -->
            <form name="openfile" method="post" autocomplete="off" action="output.php" >

            <div class="row">
                
            
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="mail">Email address</label><font color="red">*</font>
                <input type="email" class="form-control" id="mail" name= mail  aria-describedby="emailHelp" placeholder="Enter email" required>
            <small class="form-text text-muted">Specificare l'indirizzo e-mail a cui ricevere i risultati.</small>
            </div>
            </div>


            <div class="col-md-6"> 
            <div class="form-group">
                <label for="mail">Prefisso file utenze (zona)</label><font color="red">*</font>
                <input type="text" class="form-control" id="zona" name= zona  aria-describedby="emailHelp" placeholder="Inserisci il prefisso " required>
            <small class="form-text text-muted">Prefisso da usare per i file excel che avranno un formato di questo tipo YYYYMMGG_<b>prefisso</b>_<i>nomefile</i>.xlsx</small>
            </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group  ">
                
                </div>
            </div>

            
            </div>
            <div class="row">

			<div class="col-md-6"> 
                <div class="form-group  ">
                <label for="via">Via:</label> <font color="red">*</font>
                <!--select name="via-list" id="via-list" class="selectpicker show-tick form-control" 
                data-live-search="true" onChange="getCivico(this.value);" required=""-->
                <select name="via-list" id="via-list" class="selectpicker show-tick form-control" 
                data-live-search="true" onchange="writelist();" required="">

                <option value="">Seleziona la via</option>
                <?php            
                $query2="SELECT id_via, nome From topo.vie where id_comune=$1;";
                $result2 = pg_prepare($conn, "my_query2", $query2);
                $result2 = pg_execute($conn, "my_query2", array($id_comune));
                //$result2 = pg_query($conn, $query2);
                //echo $query1;    
                while($r2 = pg_fetch_assoc($result2)) { 
                    $valore=  $r2['id_via']. ";".$r2['nome'];            
                ?>
                            
                        <option name="codvia" value="<?php echo $r2['id_via'];?>" ><?php echo $r2['nome'];?></option>
                <?php } ?>

                </select>            
            </div>
            </div>
            
            <div class="col-md-6"> 
            <div class="form-group  ">

            <textarea readonly id="lista_vie" name="lista_vie" rows="4"  class="form-control" >cod_via, nome_via</textarea>
            <small class="form-text text-muted">Anteprima del file con l'elenco vie usato dall'applicativo per generare i file con le utenze. 
                In caso di errori con le vie clicca sul bottone per rimuovere l'ultima linea.<br>
                <a href="#" class="btn btn-danger btn-sm" id="removeline"><i class="far fa-trash-alt"></i></a>
                <br> o riparti dall'inizio<br>
                <a href="#" class="btn btn-info btn-sm" id="aggiorna"><i class="fas fa-redo"></i></a></small>
            </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#removeline').click(function() {
                        // pulisco tutto
                        //$('#lista_vie').val('cod_via, nome_via');
                        // solo ultima riga
                        var txt = $('#lista_vie');
                        var text = txt.val().trim("\n");
                        var valuelist = text.split("\n");
                        //var string_to_replace = "";
                        //valuelist[valuelist.length-1] = string_to_replace;
                        console.log(valuelist);
                        console.log(valuelist.length);
                        var last = valuelist[valuelist.length - 1];
                        console.log(last);
                        pippo=text.replace(last, "").replace(/\n$/, "")
                        console.log(pippo)
                        txt.val(pippo)
                        //pippo=valuelist.pop()
                        //console.log(pippo)
                        //last.removeChild(last);
                        //console.log(valuelist);
                        //txt.val(pippo.join("\n"));
                    })
                });
                $(document).ready(function() {
                    $('#aggiorna').click(function() {
                        // pulisco tutto
                        $('#lista_vie').val('cod_via, nome_via');
                    })
                });

            </script>

            
            </div>
            <div class="row">

            <div class="form-group  ">
                Il processo di estrazione delle utenze per il fuori Genova è ancora da sviluppare
            <input type="submit" disabled="" name="submit" id=submit class="btn btn-info" value="Recupera utenze">
            </div>
            </form>


</div>


</div>

<?php
require_once('req_bottom.php');
require('./footer.php');
?>

<script type="text/javascript" >

// con questa parte scritta in JQuery si evita che 
// l'uso del tasto enter abbia effetto sul submit del form


$("input#zona").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});


$(document).on("keydown", ":input:not(textarea)", function(event) {
    if (event.key == "Enter") {
        event.preventDefault();
    }
});

</script>









<script>
	function writelist(){
		var codvia_value=$("#via-list option:selected").val(); //get the value of the current selected option.
        console.log(codvia_value);
        var via_text=$("#via-list option:selected").text();
		console.log(via_text);


        document.getElementById("lista_vie").value +='\n'+ codvia_value+ ', '+via_text;

        //document.querySelector('#textlista_vie2').innerHTML = document.codvia_value

	} 

</script>
</body>

</html>