<?php
session_set_cookie_params($lifetime);
session_start();


if(!isset($_COOKIE['un'])) {
    echo "Cookie named un is not set!";
  } else {
    echo "Cookie un is set!<br>";
    echo "Value is: " . $_COOKIE['un'];
    $_SESSION['username']=$_COOKIE['un'];
  }


//$id=pg_escape_string($_GET['id']);

$user = $_SERVER['AUTH_USER'];

$username = $_SERVER['PHP_AUTH_USER'];

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

<?php require_once('./navbar_up.php');?>


      <div class="container">
 
    
    <?php
    if (!$_SESSION['username']){
        echo 'NON VA BENE';
        $_SESSION['origine']=basename($_SERVER['PHP_SELF']);
        $_COOKIE['origine']=basename($_SERVER['PHP_SELF']);
        header("location: ./login.php");
        //exit;
    }    
    ?>

            <h2> Pesi bilaterale (<i class="fas fa-user"></i> User.  <?php echo $_SESSION['username'];?>) 
        </h2>
        <!--a href='report_pesi1.php' class='btn btn-info'> Grafici </a-->


            <hr>
            <?php require_once('form_inserimento_manuale.php'); ?>
            <hr>
         


            <div class="row">
				<div class="noprint" id="toolbar">
				<select class="form-control noprint">
					<option value="">Esporta i dati visualizzati</option>
					<option value="all">Esporta tutto (lento)</option>
					<option value="selected">Esporta solo selezionati</option>
				</select>
				</div>
				<div id="tabella">
				<table  id="t_mire" class="table-hover" data-toggle="table" data-url="./tables/pesi_bilaterale.php" 
				data-show-search-clear-button="true"   data-show-export="true" data-export-type=['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'doc', 'pdf'] 
				data-search="true" data-click-to-select="true" data-show-print="true"  
				data-pagination="true" data-page-size=75 data-page-list=[10,25,50,75,100,200,500]
				data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" 
				data-filter-control="true" data-toolbar="#toolbar">
        
        
<thead>

 	<tr>
        <th class="noprint" data-field="state" data-checkbox="true"></th>    
		<th data-field="CHECK" data-sortable="true" data-visible="true" data-filter-control="select">CHECK</th>
		<th data-field="PROVENIENZE" data-sortable="true" data-visible="true" data-filter-control="select">Origine del dato</th>
		<th data-field="SPORTELLI" data-sortable="true" data-visible="true" data-filter-control="select">Sportelli</th>
        <th data-field="RIFIUTO" data-sortable="true" data-visible="true" data-filter-control="select">Rifiuto</th>
        <!--th data-field="DATA" data-sortable="true" data-visible="true" data-formatter="winLOSSFormatter" data-filter-control="input">Data</th-->
        <th data-field="DATA" data-sortable="true" data-visible="true" data-filter-control="input">Data</th>
        <th data-field="PESO" data-sortable="true" data-visible="true" data-filter-control="select">Peso[kg]</th>
        <th data-field="DESTINAZIONI" data-sortable="true" data-visible="true" data-filter-control="select">Destinazione</th>
        <th data-field="REC_ID" data-sortable="true" data-visible="true" data-formatter="nameFormatterInsert" data-filter-control="select">Destinazione</th>
    </tr>
</thead>
</table>


<script>


function winLOSSFormatter(value) {
    //var date = new Date(parseInt(value.slice(6, -2)));
    var date = new Date(value);
    var mm = date.getMonth()+1;
    var dd = date.getDay();
    var yy = new String(date.getFullYear()).substring(2);
    if (mm < 10) { 
        mm = "0"+mm;
    }
    if (dd < 10) {
        dd = "0"+dd;
    }
    return mm+'/'+dd+'/'+yy;
    //return date;
    //return date.toLocaleDateString("it");
};
/*$('#t_mire').bootstrapTable({
    url:"./tables/pesi_bilaterale.php"
});*/


function nameFormatterInsert(value, row) {
    if (value){
       if (row.CHECK=='MN'){
            return '<form onsubmit="return removeButton();"><button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>\
            <input type="hidden" id="recid" name="recid" value="'+value+'"></form>';
    }
       return ''; 
	} else {
        if(row.RIFIUTO == 'INDIFFERENZIATO') {
		    return '<form onsubmit="return clickButton2bis(\''+row.SPORTELLI+'\',1,\''+row.DESTINAZIONI+'\',\''+row.DATA+'\','+row.PESO+');">\
            <button class="btn btn-info" type="submit"><i class="fas fa-check"></i> </button>\
            </form>';
        } else {
            return row.RIFIUTO;
        }
    }
}


function nameFormatterLettura(value,row) {
	if(row.tipo=='IDROMETRO ARPA' ){
		<?php
		$query_soglie="SELECT liv_arancione, liv_rosso FROM geodb.soglie_idrometri_arpa WHERE cod='?>row.id<?php';";
		$result_soglie = pg_query($conn, $query_soglie);
		while($r_soglie = pg_fetch_assoc($result_soglie)) {
			$arancio=$r_soglie['liv_arancione'];
			$rosso=$r_soglie['liv_rosso'];
		}
		?>
		if(value < row.arancio ){
			return '<font style="color:#00bb2d;">'+Math.round(value*1000)/1000+'</font>';
		} else if (value > row.arancio && value < row.rosso) {
			return '<font style="color:#FFC020;">'+Math.round(value*1000)/1000+'</font>';
		} else if (value > row.rosso) {
			return '<font style="color:#cb3234;">'+Math.round(value*1000)/1000+'</font>';
		} else {
			return '-';
		}
	} else if(row.tipo=='IDROMETRO COMUNE'){
	//	return Math.round(value*1000)/1000;
		<?php
		$query_soglie="SELECT liv_arancione, liv_rosso FROM geodb.soglie_idrometri_comune WHERE id='?>row.id<?php';";
		$result_soglie = pg_query($conn, $query_soglie);
		while($r_soglie = pg_fetch_assoc($result_soglie)) {
			$arancio=$r_soglie['liv_arancione'];
			$rosso=$r_soglie['liv_rosso'];
		}
		?>
		if(value < row.arancio ){
			return '<font style="color:#00bb2d;">'+Math.round(value*1000)/1000+'</font>';
		} else if (value > row.arancio && value < row.rosso) {
			return '<font style="color:#FFC020;">'+Math.round(value*1000)/1000+'</font>';
		} else if (value > row.rosso) {
			return '<font style="color:#cb3234;">'+Math.round(value*1000)/1000+'</font>';
		} else {
			return '-';
		}
	} else {
		if(value==1){
			return '<i class="fas fa-circle" title="Livello basso" style="color:#00bb2d;"></i>';
		} else if (value==2) {
			return '<i class="fas fa-circle" title="Livello medio" style="color:#ffff00;"></i>';
		} else if (value==3) {
			return '<i class="fas fa-circle" title="Livello alto" style="color:#cb3234;"></i>';
		} else {
			return '-';
		}
	}		
}

</script>
</div>	<!--tabella-->







           


</div> <!--row-->

</div>
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