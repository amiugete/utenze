<?php
$lifetime=3600;
session_set_cookie_params($lifetime);
session_start();


if(!isset($_COOKIE['un'])) {
    //echo "Cookie named un is not set!";
  } else {
    //echo "Cookie un is set!<br>";
    //echo "Value is: " . $_COOKIE['un'];
    $_SESSION['username']=$_COOKIE['un'];
  }

  if (!$_SESSION['username']){
      //echo 'NON VA BENE';
      $_SESSION['origine']=basename($_SERVER['PHP_SELF']);
      //$_COOKIE['origine']=$_SESSION['origine'];
      header("location: ./login.php");
      exit;
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

    <title>Calcolo percorso bilaterale</title>
<?php 
require_once('./req.php');
require_once('./conn.php');
?> 

</head>

<body>

<?php require_once('./navbar_up.php');?>


    <div class="container">
 
    

            <h2> Calcolo percorsi bilaterale </h2>
        <!--a href='report_pesi1.php' class='btn btn-info'> Grafici </a-->


            <hr>
            <?php require_once('form_calcolo_percorso.php'); ?>
            <hr>
            
            <?php 
            if ($check_form==1){
            ?>
                <div class="row">
                    Totale elementi:
                </div>
            <?php
            }
            ?>

        <script>
                function printDiv() {
                    var divContents = document.getElementById("spazio_tabella").innerHTML;
                    var a = window.open('', '', 'height=500, width=500');
                    a.document.write('<html>');
                    a.document.write('<body > <h1>Div contents are <br>');
                    a.document.write(divContents);
                    a.document.write('</body></html>');
                    a.document.close();
                    a.print();
                }
            </script>
            <span class="spinner spinner-border spinner-border-sm mr-3" id="spinner" role="status" aria-hidden="true">
            </span>
            <div id="spazio_tabella" class="row">
            <h3>
            <div class="col-lg-12" id="tabella_title" >
                    <h3>Percorso bilaterale XXX  </h3>
            </div>
              </h3>
            <!--div class="noprint col-lg-6" >
            <button class="btn btn-info noprint" onclick="printClass('fixed-table-container')">
            <i class="fa fa-print" aria-hidden="true"></i> Stampa tabella </button>
            </div-->
				<div class="noprint" id="toolbar">
				<!--select class="form-control noprint">
					<option value="">Esporta i dati visualizzati</option>
					<option value="all">Esporta tutto (lento)</option>
					<option value="selected">Esporta solo selezionati</option>
				</select-->
				</div>
				<div id="tabella">
				<table  id="percorso" class="table-hover" data-toggle="table" data-url="./results.json" 
				data-show-search-clear-button="true"   data-show-export="true" data-export-type=['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'doc', 'pdf'] 
				data-search="true" data-click-to-select="true" data-show-print="true"  
				data-pagination="false" data-page-size=75 data-page-list=[10,25,50,75,100,200,500]
				data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" 
				data-filter-control="true" data-show-footer="false" data-toolbar="#toolbar">
        
        
<thead>

 	<tr>
        <!--th class="noprint" data-field="state" data-checkbox="true"></th-->    
		<th data-field="ordine" data-sortable="true" data-visible="true"  data-filter-control="select">Seq</th>
		<th data-field="id_piazzola" data-sortable="false" data-visible="true"  data-filter-control="select">Codice</th>
		<th data-field="indirizzo_amiu" data-sortable="false" data-visible="true"  data-filter-control="select">Indirizzo</th>
        <th data-field="num" data-sortable="false" data-filter-control="select" data-visible="true">Elementi</th>
        <th data-field="riempimento_medio" data-sortable="false" data-visible="true"  data-filter-control="select">Riempimento<br>medio [%]</th>
        <!--th data-field="aggiornamenti" data-sortable="true" data-visible="true" data-formatter="winLOSSFormatter" data-filter-control="select">Ultimo<br>aggiornamento</th-->
        <th data-field="aggiornamenti" data-sortable="false" data-visible="true" data-filter-control="input">Ultimo<br>aggiornamento</th>
        <!--th data-field="RIFIUTO" data-sortable="true" data-visible="true" data-filter-control="select">Rifiuto</th>
        <th data-field="DATA" data-sortable="true" data-visible="true" data-formatter="winLOSSFormatter" data-filter-control="input">Data</th>
        <th data-field="PESO" data-sortable="true" data-visible="true" data-filter-control="select">Peso[kg]</th>
        <th data-field="DESTINAZIONI" data-sortable="true" data-visible="true" data-filter-control="select">Destinazione</th>
        <th data-field="REC_ID" data-sortable="true" data-visible="true" data-formatter="nameFormatterInsert" data-filter-control="select">Destinazione</th-->
    </tr>
</thead>
</table>



<script>



function totalTextFormatter(data) {
    return 'Total'
  }

  function totalNoneFormatter(data) {
    return '-'
  }

  function totalNameFormatter(data) {
    return data.length
  }

  function totalPriceFormatter(data) {
    var field = this.field
    return '$' + data.map(function (row) {
      return +row[field].substring(1)
    }).reduce(function (sum, i) {
      return sum + i
    }, 0)
  }


  var materiale1='';

  $('#materiale').change(function() {
    materiale1= $( "#materiale option:selected" ).text();
    console.log('Titolo tabella');
    console.log(materiale1);
    console.log('ok materiale');
});



  var $table = $('#percorso');

                $(function() {
                    $table.bootstrapTable({
                    printPageBuilder: function (table) {
                        return `
                <html>
                <head>
                <style type="text/css" media="print">
                @page {
                    size: auto;
                    margin: 25px 0 25px 0;
                }
                </style>
                <style type="text/css" media="all">
                table {
                    border-collapse: collapse;
                    font-size: 12px;
                }
                table, th, td {
                    border: 1px solid grey;
                }
                th, td {
                    text-align: center;
                    vertical-align: middle;
                }
                p {
                    font-weight: bold;
                    margin-left:20px;
                }
                table {
                    width:94%;
                    margin-left:3%;
                    margin-right:3%;
                }
                div.bs-table-print {
                    text-align:center;
                }
                </style>
                </head>
                <title>Print Table</title>
                <body>
                <div id="titolo_stampa"> <h3>Stampa percorso bilaterale - Rifiuto `+materiale1+` </H3></div>
                <div class="bs-table-print">${table}</div>
                </body>
                </html>`
                    }
                    })
                    })
  
  



  



function winLOSSFormatter(value) {
    //var date = new Date(parseInt(value.slice(6, -2)));
    console.log(value);
    if (value==null){
        return '';
    }else {
        var date = new Date(value);
        var mm = date.getMonth()+1;
        console.log('Mese:'+mm);
        var dd = date.getDay();
        console.log('Giorno:'+dd);
        var yy = new String(date.getFullYear()).substring(2);
        if (mm < 10) { 
            mm = "0"+mm;
        }
        if (dd < 10) {
            dd = "0"+dd;
        }
        var hh= date.getHours();
        console.log(hh);
        var min= date.getMinutes();
        if (min < 10) {
            min = "0"+min;
        }
        console.log(min);
        return hh+':'+min+' '+mm+'/'+dd;
    }
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