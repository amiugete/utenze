<?php

$id=pg_escape_string($_GET['id']);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Tabella gates</title>
<?php 
require_once('./req.php');
require_once('./conn.php');

$query="SELECT descr 
FROM terra.posizione_telecamere
WHERE id =$1
";

$result = pg_prepare($conn,"myquery1", $query);
$result = pg_execute($conn,"myquery1", array($id));
while($r = pg_fetch_assoc($result)) {
      $gate=$r['descr'];
}


?>
    
</head>

<body>


      <div class="container">
      
            <div class="row">
                <div class="col-lg-12">
                 
                    <h1 class="page-header"> <i class="fas fa-skull-crossbones"></i> Merci pericolose in transito dai gate Lose+
                    <br><small> (dati registrati dal 28-2-2021)</small></h1>
                </div>

                <div class="row">
                <div class="col-lg-12">
<div style="overflow-x:auto;">

      	
    <table  id="sostanze"
    class="table-hover" 
    data-toggle="table"  
    
    data-show-export="false" data-click-to-select="true" data-show-refresh="true" data-show-search-clear-button="true" 

		data-url="./griglia_totale.php"
         data-search="true"  data-pagination="true" 
        data-page-size=50 data-page-list=[10,25,50,100,200,500] 
		data-sidePagination="true"  data-show-toggle="true" 
         data-show-columns="true" 
		>
      	

        
        
<thead>

 	<tr>
    <th data-field="targa" data-sortable="true" data-visible="true" data-filter-control="input">Codice<br>ADR<br>(Targa)</th> 
    <th data-field="descrizione_merce_pericolosa" data-sortable="true" data-visible="true" data-filter-control="input">Merce</th>
    <th data-field="mycount" data-sortable="true" data-visible="true" data-filter-control="select">Numero<br>transiti<br>totali</th>
    <th data-field="mycount_25" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=25">gate 25</a>
    </th>
    <th data-field="mycount_26" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=26">gate 26</a>
    </th>
    <th data-field="mycount_27" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=27">gate 27</a>
    </th>
    <th data-field="mycount_28" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=28">gate 28</a>
    </th>
    <th data-field="mycount_29" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=29">gate 29</a>
    </th>
    <th data-field="mycount_30" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=30">gate 30</a>
    </th>
    <th data-field="mycount_31" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=31">gate 31</a>
    </th>
    <th data-field="mycount_32" data-sortable="true" data-visible="true" data-filter-control="select">
    Numero<br>transiti<br><a href="index.php?id=32">gate 32</a>
    </th>

  </tr>
</thead>

</table>

<script>
  function mounted() {
    $('#sostanze').bootstrapTable()
  };


  function nameFormatterMappa1(value, row) {
	//var test_id= row.id;
	return ' <button type="button" class="btn btn-info" data-toggle="modal" data-target="#g1_'+value+'">\
  <i title="Serie temporali" class="fas fa-chart-line"></i></button> \
    <div class="modal fade" id="g1_'+value+'" role="dialog"> \
    <div class="modal-dialog modal-xl"> \
      <div class="modal-content">\
        <div class="modal-header">\
          <button type="button" class="close" data-dismiss="modal">&times;</button>\
          <h4 class="modal-title"><?php echo $gate;?> </h4>\
        </div>\
        <div class="modal-body">\
        <iframe class="embed-responsive-item" style="width:100%; padding-top:0%; height:600px;" src="./time.php?id=<?php echo $id;?>&m='+value+'"></iframe>\
        </div>\
        <!--div class="modal-footer">\
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
        </div-->\
      </div>\
    </div>\
  </div>\
</div>\
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#g2_'+value+'">\
<i title="Media oraria transiti giornalieri" class="fas fa-chart-bar"></i></button> \
    <div class="modal fade" id="g2_'+value+'" role="dialog"> \
    <div class="modal-dialog modal-xl"> \
      <div class="modal-content">\
        <div class="modal-header">\
          <button type="button" class="close" data-dismiss="modal">&times;</button>\
          <h4 class="modal-title"><?php echo $gate;?> </h4>\
        </div>\
        <div class="modal-body">\
        <iframe class="embed-responsive-item" style="width:100%; padding-top:0%; height:600px;" src="./time_day.php?id=<?php echo $id;?>&m='+value+'"></iframe>\
        </div>\
        <!--div class="modal-footer">\
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
        </div-->\
      </div>\
    </div>\
  </div>\
</div>';
}
	
	

</script>
</div>

</div>
</div>


</div>

<?php
require_once('req_bottom.php');
?>


