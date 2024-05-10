<?php

?>


<!--script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script-->



<!-- Bootstrap Core JavaScript -->
<script src="./vendor/bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>

<!-- Bootstrap Plugins -->
<!--script src="./bootstrap-table-1.18.3/dist/bootstrap-table.js"></script-->


<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>




<!--script src="./bootstrap-datepicker/js/bootstrap-datepicker.js"></script-->
<script src="./vendor/bootstrap-table/dist/bootstrap-table.min.js"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/FileSaver/FileSaver.min.js"></script>


<script src="./vendor/bootstrap-table/dist/extensions/export/bootstrap-table-export.js" ></script>




<script src="./vendor/bootstrap-table/dist/extensions/print/bootstrap-table-print.min.js" ></script>
<script src="./vendor/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.js" ></script>
<script src="./vendor/bootstrap-table/dist/extensions/auto-refresh/bootstrap-table-auto-refresh.js"></script>
<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
function printClass(className) {
	//it is an array so i using only the first element
     var printContents = document.getElementsByClassName(className)[0].innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>