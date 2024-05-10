<?php

?>



<script type="text/javascript">  

            function clickButton2bis(mezzo, serv, dest, data, peso) {  
                console.log('Sono qua');
                console.log(mezzo);
                console.log(serv);
                console.log(dest);
                console.log(data);
                console.log(peso);

                // prevent form from submitting
				return false;
            }



			function clickButton2() {
				var mezzo=document.getElementById('mezzo').value;
				var serv=document.getElementById('serv').value;
                var dest=document.getElementById('dest').value;
                var data=document.getElementById('js-date').value;
                var peso=document.getElementById('peso').value;
				//alert(mira);
				//alert(mira.value);
				var url ="inserimenti/nuovo_peso_bilaterale.php?m="+encodeURIComponent(mezzo)+"&s="+encodeURIComponent(serv)+"&d="+encodeURIComponent(dest)+"&dd="+encodeURIComponent(data)+"&p="+encodeURIComponent(peso)+"";
				// get the URL
				http = new XMLHttpRequest(); 
				http.open("GET", url, true);
				http.send();

				//alert('Dato della mira inserito. Per visualizzare il dato aggiorna la tabella con l\'apposito tasto');
				//$('#msg').html(html);
				$('#mezzo').val('NO');
				$('#serv').val('').trigger('change');
				$('#dest').val('');
                $('#js-date').val('');
                $('#peso').val('');
				$('#t_mire').bootstrapTable('refresh', {silent: true});

				// prevent form from submitting
				return false;
			}

            function removeButton() {
                var id=document.getElementById('recid').value;
                // chiamo il codice per la rimozione
                var url ="inserimenti/elimina_peso_bilaterale.php?id="+encodeURIComponent(id)+"";
				
                // get the URL
				http = new XMLHttpRequest(); 
				http.open("GET", url, true);
				http.send();

                $('#t_mire').bootstrapTable('refresh', {silent: true});

				// prevent form from submitting
				return false;

            }


			</script>
			
			<!--form-->    
	        <!--form name="form1" target="content" autocomplete="off" action="eventi/nuova_lettura2.php" method="POST" id="submit_form"-->
			<form action="" onsubmit="return clickButton2();">
	         

        <div class="row">
				
            
            <div class="form-group col-lg-6">
				<label for="mezzo">Mezzo </label><font color="red">*</font>'
				
				
				<!--select class="selectpicker show-tick form-control" data-live-search="true" -->
				<select class="selectpicker show-tick form-control" 
                data-live-search="true"  name="mezzo" id="mezzo" required="">
				<option name="mezzo" value="NO" > ... </option>
			   
			   <?php
	
				$query_mezzi="SELECT TARGA, SPORTELLO, DOCUMENTO, DESCR_MEZZO, STATO, ATTIVO, DATA_CREAZIONE
                    FROM ECOS.DB_TARGHE_BILATERALI";


                $result_mezzi = oci_parse($oraconn_ecos, $query_mezzi);
                oci_execute($result_mezzi);
                //echo $query;



                //$rows = array();
   
				while($r_p = oci_fetch_assoc($result_mezzi)) {
					?>
						<option name="mezzo" value="<?php echo trim($r_p["SPORTELLO"]);?>">Sport. <?php echo $r_p["SPORTELLO"] . "(". $r_p["TARGA"].")";?></option>
					<?php
				} 
				?>
				 </select>           
                <small>Mezzi presi da InfoPM sulla base delle famiglie O6 e O7</small>
			</div>
	

            <div class="form-group col-lg-6">
				<label for="serv">Servizio </label><font color="red">*</font>'
				
				
				<!--select class="selectpicker show-tick form-control" data-live-search="true" -->
				<select class="selectpicker show-tick form-control" 
                data-live-search="true"  name="serv" id="serv" required="">
				<option name="serv" value="" > ... </option>
			   
                
                
                <?php
                    
                    $query_serv="SELECT ID_SERVIZIO, DESC_SERVIZIO, TIPO_RIFIUTO,
                CER
                FROM ANAGR_SERVIZI as2 
                WHERE ID_SERVIZIO IN (1,39,40,30)";



                $result_serv = oci_parse($oraconn, $query_serv);
                oci_execute($result_serv);
                //echo $query;



                //$rows = array();

                while($r_p = oci_fetch_assoc($result_serv)) {
                    ?>
                        <option name="serv" value="<?php echo $r_p["ID_SERVIZIO"];?>"><?php echo $r_p["DESC_SERVIZIO"] . "(". $r_p["CER"].")";?></option>
                    <?php
                } 
                ?>
                </select> 

            </div>




            <div class="form-group col-lg-6">
				<label for="dest">Destinazione </label><font color="red">*</font>'
				
				
				<!--select class="selectpicker show-tick form-control" data-live-search="true" -->
				<select class="selectpicker show-tick form-control" 
                data-live-search="true"  name="dest" id="dest" required="">
				<option name="dest" value="" > ... </option>
			   
                
                
                <?php
                    
                    $query_dest=" SELECT ID_DESTINAZIONE, DESTINAZIONE FROM ANAGR_DESTINAZIONI ad 
                    ORDER BY ID_DESTINAZIONE";



                $result_dest = oci_parse($oraconn, $query_dest);
                oci_execute($result_dest);
                //echo $query;



                //$rows = array();

                while($r_p = oci_fetch_assoc($result_dest)) {
                    ?>
                        <option name="dest" value="<?php echo $r_p["ID_DESTINAZIONE"];?>"><?php echo $r_p["DESTINAZIONE"] ;?></option>
                    <?php
                } 
                ?>
                </select> 

            </div>

            <div class="form-group col-lg-3">		
                <label for="data_inizio" >Data </label>                 
						<input type="text" class="form-control" name="data" id="js-date" required>
			</div>
			
            
            <div class="form-group col-lg-3">		
                <label for="data_inizio" >Peso [kg]</label>                 
						<input type="number" class="form-control" name="peso" id="peso" required>
			</div>

        </div>

        <div class="row">
             
             
			 <!-- molto  importante il return per non ricaricare la pagina!! -->
             <!--button  name="conferma2" id="conferma2" type="submit" onclick="return clickButton();" class="btn btn-primary">
			 Inserisci lettura</button-->
			 <input  name="conferma2" id="conferma2" type="submit" class="btn btn-primary" value="Inserisci lettura">
			 
        </div>
        </form>
			

        <script>

        $(document).ready(function() {
            $('#js-date').datepicker({
                format: "yyyy-mm-dd",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });
        });
        </script>