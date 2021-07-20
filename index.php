<?php

$id=pg_escape_string($_GET['id']);

if (isset($_POST)){

    if ($_POST['submit']) {
         //Save File

         echo "<script>
         $(window).load(function(){
             $('#thankyouModal').modal('show');
         });
    </script>";

        ?>


         <div class="modal" id="thankyouModal" tabindex="-1" role="dialog">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <p>
                   
               <?php
               echo "Grazie, riceverai i dati richiesti alla mail ". $_POST['mail'] . " ento pochi minuti. 
               In caso di problemi ti invitiamo a contattare il gruppo GETE via mail (assterritorio@amiu.genova.it) 
               o telefonicamente al 010 55 84496 ";
               ?>
            
            </p>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-primary">Save changes</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
           </div>
         </div>
       </div>

       <?php


         $file = fopen('./file/elenco_vie.txt',"w+");
         $text = $_POST["lista_vie"];
         fwrite($file, $text);
         fclose($file);
     }
 
 }

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
      

            <h2> Seleziona vie da cui recuperare le utenze </h2>
            <hr>
            <form name="openfile" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            <div class="row">
                
            
            <div class="col-md-6"> 
            <div class="form-group">
                <label for="mail">Email address</label>
                <input type="email" class="form-control" id="mail" name= mail  aria-describedby="emailHelp" placeholder="Enter email">
            <small class="form-text text-muted">Specificare l'indirizzo e-mail a cui ricevere i risultati.</small>
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
                $query2="SELECT id_via, nome From topo.vie where id_comune=1;";
                $result2 = pg_query($conn, $query2);
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
            </div>
            </div>

            
            </div>
            <div class="row">

            <div class="form-group  ">
            <input type="submit" name="submit" class="btn btn-info" value="Recupera utenze">
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