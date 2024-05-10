<?php
session_start();
$_SESSION['waypoints']='';
$check_form=0;

$query_quartieri='SELECT * FROM topo.quartieri WHERE id_comune=1 and id_municipio in (4,3) ORDER BY nome;';

?>



<script type="text/javascript">  


       






$(document).ready(function(){
    $("#spazio_tabella").hide();
});

			function clickButton2() {
				var mat=document.getElementById('materiale').value;
                //var materiale= document.getElementById('materiale').text();
				var materiale=$( "#materiale option:selected" ).text();
                var dep=document.getElementById('dep').value;
                var num=document.getElementById('num').value;
                var riemp=document.getElementById('riemp').value;
                //var test=document.getElementById('#checkArray').value;
                var quartieri=''
                var array = [];
                console.log('*******');
                $("input:checkbox[name=filter]:checked").each(function() {
                    console.log($(this).val());
                    if (quartieri=='') {
                        quartieri=$(this).val()
                    } else {
                        quartieri=quartieri+','+$(this).val()
                    }
                });
                
                console.log(quartieri);
                console.log('*******');
                
				console.log(mat);
                console.log(materiale);
                
                if (riemp == '') {
                    riemp=0;
                }
                console.log(riemp);
                //alert(mira);
				//alert(mira.value);
				var url ="tables/calcolo_percorso_bilaterale.php?m="+encodeURIComponent(mat)+"&d="+encodeURIComponent(dep)+"&n="+encodeURIComponent(num)+"&r="+encodeURIComponent(riemp)+"&q="+encodeURIComponent(quartieri)+"";
				
                console.log(url);
                // get the URL
				http = new XMLHttpRequest(); 
				http.open("GET", url, true);
                http.send();
                console.log('Verifichiamo lo stato');
                console.log(http.readyState);
                http.onreadystatechange = function () {
                    if (http.readyState !== 4) {
                        
                        console.log(http.readyState)
                    } else if (http.readyState === 4) {               
                        console.log(http.readyState);
                        
                
                        
                        $(document).ready(function(){
                            
                            console.log('OK apro 1')
                            $("#notifica").text($("#notifica").text().replace("RIF", materiale));
                            $("#notifica").text($("#notifica").text().replace("N_PIAZ", num));
                            if (riemp==0) {
                                $("#notifica").text($("#notifica").text().replace("- ()", "- Nessun limite al riempimento"));
                            } else {
                                $("#notifica").text($("#notifica").text().replace("- ()", "- ("+riemp+")"));
                            }
                            let date = new Date();  
                            let options = {  
                                weekday: "long", year: "numeric", month: "short",  
                                day: "numeric", hour: "2-digit", minute: "2-digit"  
                            };  
                            var print_data=date.toLocaleTimeString("it-IT", options)
                            console.log(print_data);
                            $("#ora_notifica").text($("#ora_notifica").text().replace("ORA_CALCOLO", print_data));
                            console.log($('#ora_notifica').text())
                            //$("#titolo_stampa").text($("#titolo_stampa").text().replace("Rifiuto XXX", "Rifiuto "+materiale));
                            $("#tabella_title").text($("#tabella_title").text().replace("XXX", materiale));
                            // cambio colonna che però non agisce sulla stampa
                            //$('.table tr th:eq(3)').text($('.table tr th:eq(3)').text().replace("XXXXXXXX", materiale));
                            
                            //$('.table tr th').find('XXXXXXXX').text(materiale)
                            //$('table tr th:eq(3)').text(materiale);
                            $('.toast').toast('show');
                            console.log('OK apro 1 bis')
                            $("#spazio_tabella").show();
                            //printPageBuilder.call();
                        });
                        //$('#percorso').bootstrapTable('refresh', {url: url, silent: true});
                        $('#percorso').bootstrapTable('refresh', {silent: true});
                        //var google_url = "https://www.google.com/maps/dir/?api=1&origin=44.4316351,8.9601801&destination=44.4316351,8.9601801&waypoints="+encodeURIComponent(<?php echo $_SESSION['waypoints'];?>);
                        console.log(<?php echo $_SESSION['waypoints']?>);
                    }
                }
                
                
                //$('#percorso').bootstrapTable('refresh', {silent: true});

				// prevent form from submitting
				return false;

            }

			</script>
			
			<!--form-->    
	        <!--form name="form1" target="content" autocomplete="off" action="eventi/nuova_lettura2.php" method="POST" id="submit_form"-->
			<form action="" onsubmit="return clickButton2();">
	         

        <div class="row">
				
            
            <div class="form-group col-lg-3">
				<label for="materiale">Materiale </label><font color="red">*</font>
				
				
				<!--select class="selectpicker show-tick form-control" data-live-search="true" -->
				<select class="selectpicker show-tick form-control" 
                data-live-search="true"  name="materiale" id="materiale" required="">
				<option name="materiale" value="NO" > ... </option>
			   
			   <?php
	
				$query_materiale="SELECT *
                    FROM idea.codici_cer";


                $result_materiale = pg_query($conn, $query_materiale);
                //oci_execute($result_mezzi);
                //echo $query;



                //$rows = array();
   
				while($r_p = pg_fetch_assoc($result_materiale)) {
					?>
						<option name="materiale" value="<?php echo trim($r_p["codice_cer"]);?>"><?php echo $r_p["descrizione"] ;?></option>
					<?php
				} 
				?>
				 </select>           
                <small>Materiali oggetto della raccolta bilaterale</small>
			</div>
	

            <div class="form-group col-lg-3">
				<label for="dep">Partenza/arrivo mezzo</label><font color="red">*</font>
				
				
				<!--select class="selectpicker show-tick form-control" data-live-search="true" -->
				<select class="selectpicker show-tick form-control" 
                data-live-search="true"  name="dep" id="dep" required="">
			   
                
                
                <?php
                    
                    $query_d='SELECT id, id_piazzola FROM "input".depositi';



                $result_d = pg_query($conn_routing, $query_d);
                //echo $query;



                //$rows = array();

                while($r_p = pg_fetch_assoc($result_d)) {
                    ?>
                        <option name="dep" value="<?php echo $r_p["id"];?>"><?php echo $r_p["id_piazzola"];?></option>
                    <?php
                } 
                ?>
                </select> 

            </div>


		
            
            <div class="form-group col-lg-3">		
                <label for="num" >Numero piazzole</label><font color="red">*</font>                 
					<input type="number" class="form-control" step=1 min=0 name="num" id="num" required>
                <small>Numero di piazzole massimo con cui calcolare il percorso</small>
			</div>

            <div class="form-group col-lg-3">		
                <label for="riemp" >Valore riempimento [%]</label>                 
					<input type="number" class="form-control" step=10 min=0 max=100 name="riemp" id="riemp">
                <small>OPZIONALE: Valore di riempimento minimo da considerare</small>
			</div>


        </div>

        <?php
            
            $result = pg_query($conn, $query_quartieri);
	         #echo $result;
	         //exit;
	         //$rows = array();
            //echo '<div class="form-check form-check-inline">';
            echo '<div class="row">';
	         while($r = pg_fetch_assoc($result)) {
				echo '<div class="form-check col-lg-3"><div class="cccc">
                <span class="checkbox payment-radio"><fieldset id="checkArray">';
	            #echo '  <input class="form-check-input" type="checkbox" id="filtro_q" name="filter'.$r['id_quartiere'].'"  value=1" checked>';
	            echo '  <input class="form-check-input" type="checkbox" name="filter"  value='.$r['id_quartiere'].' checked>';
                echo '  <label class="form-check-label" for="inlineCheckbox1" >'.$r['nome'].'</label>';
	            echo "</fieldset></span></div></div>";
	            
            }
            echo "</div>";

        ?>

       


        <div class="row">
             
             
			 <!-- molto  importante il return per non ricaricare la pagina!! -->
             <!--button  name="conferma2" id="conferma2" type="submit" onclick="return clickButton();" class="btn btn-primary">
			 Inserisci lettura</button-->
			 <input  name="conferma2" id="conferma2" type="submit" class="btn btn-primary" value="Calcola percorso">
			 
        </div>
        </form>
			

        <script>


var verifyCheckBoxQuartieri = function () {
    var checkboxes = $('.cccc .checkbox');
    var inputs = checkboxes.find('input');
    var first = inputs.first()[0];
    //console.log('****************************************')
    //console.log(checkboxes.find('input:checked').length);
    //console.log('****************************************')
    inputs.on('change', function () {
        this.setCustomValidity('');
    });

    first.setCustomValidity(checkboxes.find('input:checked').length === 0 ? 'Scegli almeno un quartiere' : '');
}

$('#conferma2').click(verifyCheckBoxQuartieri);


        $(document).ready(function() {
            $('#js-date').datepicker({
                format: "yyyy-mm-dd",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });
        });
        </script>

<div class="toast" data-autohide="false">
    <div class="toast-header">
      <strong class="mr-auto text-primary">Percorso calcolato</strong>
      <small id="ora_notifica" class="text-muted">ORA_CALCOLO</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    </div>
    <div id="notifica" class="toast-body">
      <b>RIF - N_PIAZ Piazzole - ()</b>  
    </div>
  </div>


  