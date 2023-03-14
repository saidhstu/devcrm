<?php

include('database.php');





if(isset($_POST["commission_status"]))

                                {

                                    echo "<table class='table' id='commission-table1'>

                                            <thead>

                                                <tr>

                                                    <th>Invoice #</th>

                                                    <th>Amount</th>

                                                    <th>Record Locator(PNR)</th>

                                                    <th>Ticket Number</th>

                                                    <th>Date</th>

                                                    <th>Customer</th>

                                                    <th>Commission</th>

                                                    <th>Commission Status</th>

                                                    <th>Agent</th>

                                                    <th>Action</th>

                                                </tr>

                                            </thead>

                                            <tbody>";

                                    

                                    

									                 $commission_status = $_POST['commission_status'];

                                    $from_date = $_POST['from_date'];

                                    $to_date = $_POST['to_date'];

                                    $view_agent = $_POST['view_agent'];

									 

                                    

                                    $i=1;

                                    $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices WHERE id<>0";
                                    if (!empty($from_date) && !empty($to_date)) {
                                      $sql1.=" AND date(date) between '$from_date' and '$to_date'";
                                    }
                                    if (!empty($commission_status) && $commission_status!='All') {
                                      $sql1.=" AND commission_status='$commission_status'";
                                    }
                                    if (!empty($view_agent) && $view_agent!='All') {
                                      $sql1.=" AND sale_agent='$view_agent'";
                                    }
                                    $sql1.=" AND NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

                                    
/*
    								if($commission_status=="Paid")

    								{

    								  $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and sale_agent='$view_agent' and commission_status='Paid' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}

    								if($commission_status=="Unpaid")

    								{

    								  $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and sale_agent='$view_agent' and commission_status='Unpaid' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}

    								if($commission_status=="All")

    								{								  

                                      $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and sale_agent='$view_agent' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}

    								if($commission_status=="Paid" and $view_agent=="All")

    								{

    								  $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and commission_status='Paid' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}

    								if($commission_status=="Unpaid" and $view_agent=="All")

    								{

    								  $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and commission_status='Unpaid' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}

    								if($commission_status=="All" and $view_agent=="All")

    								{								  

                                      $sql1="select id,number,prefix,date,clientid,currency,sale_agent,total,commission_status from tblinvoices where date(date) between '$from_date' and '$to_date' and NOT EXISTS ( SELECT invoiceid FROM invoice_refund WHERE invoiceid = id )";

    								}*/

    								//print_r($sql1);die();

                                    $res1=mysqli_query($con,$sql1);

                                    while($fetch1=mysqli_fetch_array($res1))

                                    {

                                       

                                       

                                       $id = sprintf('%06d',$fetch1["number"]);

                                       $ids = $fetch1["id"];

                                       $prefix = $fetch1["prefix"];

                                       $date = date("Y",strtotime($fetch1["date"]));

                                       $invoice = $prefix.$date."/".$id;

                                       

                                       $total = $fetch1["total"];

                                       $datecreated = date("Y-m-d",strtotime($fetch1["date"])); 

                                       $clientid = $fetch1["clientid"];

                                       $currency = $fetch1["currency"];

                                       $sale_agent = $fetch1["sale_agent"];

                                       $commission_status = $fetch1["commission_status"];

                                       

                                       $sql2="select company from tblclients where userid='$clientid'";

                                       $res2=mysqli_query($con,$sql2);

                                       $fetch2=mysqli_fetch_array($res2);

                                       $customer = $fetch2["company"];

                                       

                                       $sql3="select symbol from tblcurrencies where id='$currency'";

                                       $res3=mysqli_query($con,$sql3);

                                       $fetch3=mysqli_fetch_array($res3);

                                       $symbol = $fetch3["symbol"];

                                       $total_with_symbol = $symbol.sprintf("%.2f", $total);

                                       

                                       $sql4="select value from tblcustomfieldsvalues where relid='$fetch1[id]' and fieldid='17'";

                                       $res4=mysqli_query($con,$sql4);

                                       $fetch4=mysqli_fetch_array($res4);

                                       $commission = $fetch4["value"];

                                       $commission_with_symbol = $symbol.sprintf("%.2f", $commission);

                                       if($commission=="")

                                       $commission_with_symbol = sprintf("%.2f", $commission);

                                       else

                                       $commission_with_symbol = $symbol.sprintf("%.2f", $commission);

                                       

                                       $sql5="select firstname,lastname from tblstaff where staffid='$sale_agent'";

                                       $res5=mysqli_query($con,$sql5);

                                       $fetch5=mysqli_fetch_array($res5);

                                       $firstname = $fetch5["firstname"];

                                       $lastname = $fetch5["lastname"];

                                       $agent = $firstname." ".$lastname;

                                       

                                       $sql6="select COUNT(id) as total_invoice from tblinvoices";

                                       $res6=mysqli_query($con,$sql6);

                                       $fetch6=mysqli_fetch_array($res6);

                                       $total_invoice=$fetch6["total_invoice"];

                                      

                                       

                                       

                                       $sql7="select value from tblcustomfieldsvalues where relid='$fetch1[id]' and fieldid='5'";

                                       $res7=mysqli_query($con,$sql7);

                                       $fetch7=mysqli_fetch_array($res7);

                                       $PNR = $fetch7["value"];

                                       

                                       $ticket_numbers = '';

                                       $sql8="select ticket_number from tblticket_number where invoiceid='$fetch1[id]'";

                                       $res8=mysqli_query($con,$sql8);

                                      while($fetch8=mysqli_fetch_array($res8))

                                      {

                                       $ticket_number = $fetch8["ticket_number"];

                                       $ticket_numbers .= $ticket_number.',  ';

                                      } 

                                       if($commission_status=="Unpaid")

                                       $class="label label-danger  s-status invoice-status-1";

                                       else

                                       $class="label label-success  s-status invoice-status-2";

                                        

                                        echo "<tr>

                                                <td>$id</td>

                                                <td>$total_with_symbol</td>

                                                <td>$PNR</td>

                                                <td>$ticket_numbers</td>

                                                <td>$datecreated</td>

                                                <td>$customer</td>

                                                <td>$commission_with_symbol</td>

                                                <td><span class='$class'>$commission_status</span></td>

                                                <td>$agent</td>

                                                <td><button type='button' id='$ids' value='$ids' onclick='myFunctions(this.value)' data-toggle='modal' data-target='#myModal'  data-toggle='tooltip' title='Update Commission Status' class='btn btn-default btn-with-tooltip' data-placement='bottom' data-original-title='Update Commission Status' style='margin:0px 3px !important;'> <i class='fa fa-pencil-square-o'></i></button></td>

                                              </tr>";

                                    $i++; 

                                    

                                    

                                    }

                                    echo "</tbody>

                                            <tfoot>

                                                <tr>

                                                    <th><strong>Total</strong></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                    <th></th>

                                                </tr>

                                            </tfoot>

                                        </table>";

                                    

                                }

                               



else

{

    echo "Bad Request";

}

?>



<!-- <script type="text/javascript" id="vendor-js" src="https://crm.manninternationaltravel.com/assets/builds/vendor-admin.js?v=2.4.0"></script> -->

<!-- <script type="text/javascript" id="jquery-migrate-js" src="https://crm.manninternationaltravel.com/assets/plugins/jquery/jquery-migrate.min.js?v=2.4.0"></script> -->

<!-- <script type="text/javascript" id="datatables-js" src="https://crm.manninternationaltravel.com/assets/plugins/datatables/datatables.min.js?v=2.4.0"></script> -->





<script>

$(document).ready(function(){

    

setTimeout(function(){

$(".mymsg").hide();

},3000);

    



var table1 = $("#commission-table1").DataTable({

    

   "pageLength": 25,

    "order":[[0,"desc"]],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    "columnDefs": [

    { "type": "num", "targets": 0 }],

    dom: 'Bfrtip',

        buttons: [

            {

                extend: 'pageLength',

                

            },

            {

                extend: 'excel',

                filename: 'Commission Report',

                title: 'Commission Report',

                footer: 'true',

                customize: function( xlsx ) {

                $(xlsx.xl["styles.xml"]).find('numFmt[numFmtId="164"]').attr('formatCode', '[$$-en-AU]#,##0.00;[Red]-[$$-en-AU]#,##0.00');

                }

            },

            {

                extend: 'print',

                filename: 'Commission Report',

                title: 'Commission Report',

                footer: 'true'

            },

            {

                extend: 'pdf',

                filename: 'Commission Report',

                title: 'Commission Report',

                footer: 'true'

            }

            

        ],

      

 

       "footerCallback": function ( tfoot, data, start, end, display ) {

            var api = this.api(), data;

 

            // Remove the formatting to get integer data for summation

            var intVal = function ( i ) {

                return typeof i === 'string' ?

                    i.replace(/[\$,]/g, '')*1 :

                    typeof i === 'number' ?

                        i : 0;

            };

 

            // Total over all pages

            total = api

                .column( 1 )

                .data()

                .reduce( function (a, b) {

                    return intVal(a) + intVal(b);

                }, 0 );

 

            // Total over this page

            pageTotal = api

                .column( 1, { page: 'current'} )

                .data()

                .reduce( function (a, b) {

                    return intVal(a) + intVal(b);

                }, 0 );

 

            // Update footer

            $( api.column( 1 ).footer() ).html(

                '<strong>$'+parseFloat(pageTotal).toFixed(2) +' ( $'+ parseFloat(total).toFixed(2) +' )</strong>'

            );

            

            

            

            // Total over all pages

            total = api

                .column( 6 )

                .data()

                .reduce( function (a, b) {

                    return intVal(a) + intVal(b);

                }, 0 );

 

            // Total over this page

            pageTotal = api

                .column( 6, { page: 'current'} )

                .data()

                .reduce( function (a, b) {

                    return intVal(a) + intVal(b);

                }, 0 );

 

            // Update footer

            $( api.column( 6 ).footer() ).html(

                '<strong>$'+parseFloat(pageTotal).toFixed(2) +' ( $'+ parseFloat(total).toFixed(2) +' )</strong>'

            );

            

        } 

      

        

    });    

    

});





</script>