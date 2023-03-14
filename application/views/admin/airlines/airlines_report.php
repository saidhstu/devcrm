<title>Commission Report</title>
<?php init_head(); ?>
<style>
   i.fa.fa-share.fa-fw.fa-lg ,i.fa.fa-check-square-o.fa-fw.fa-lg ,i.fa.fa-clock-o.fa-fw.fa-lg ,i.fa.fa-bell-o.fa-fw.fa-lg{
   line-height: 55px;
   }
   i.fa.fa-bars {
   line-height: 26px;
   }
   #loader {
   border: 8px solid #f3f3f3;
   border-radius: 50%;
   border-top: 8px solid #3498db;
   width: 60px;
   height: 60px;
   -webkit-animation: spin 2s linear infinite; /* Safari */
   animation: spin 2s linear infinite;
   }
   /* Safari */
   @-webkit-keyframes spin {
   0% { -webkit-transform: rotate(0deg); }
   100% { -webkit-transform: rotate(360deg); }
   }
   @keyframes spin {
   0% { transform: rotate(0deg); }
   100% { transform: rotate(360deg); }
   }
</style>

<div id="wrapper" style="min-height: 1500px !important;">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
                  <form id="commission_form" method="POST">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label" for="from_date"><?php echo _l('From Date'); ?></label>
                              <input type="date" id="from_date" name="from_date" class="form-control datepicker" value="<?= !empty($fromdate)?$fromdate:''; ?>" autocomplete="off" aria-invalid="false">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label" for="to_date"><?php echo _l('To Date'); ?></label>
                              <input type="date" id="to_date" name="to_date" class="form-control datepicker" value="<?= !empty($todate)?$todate:''; ?>" autocomplete="off" aria-invalid="false">
                           </div>
                        </div>
                       
                        <div class="col-md-3 leads-filter-column">
                           <label for="report-from" class="control-label">Filter By Agent</label>
                           <select id="view_agent" name="view_agent" class="form-control" data-width="100%">
                              <option value="">Select agent</option>
                              <?php if(is_admin()){?>
                              <option value="All" <?= (!empty($sale_agent)&&$sale_agent=='All')?'selected':''; ?>>All</option>
                              <?php if (!empty($agents)) { ?>
                              <?php foreach ($agents as $result) { ?>
                                <option value="<?= $result->staffid; ?>" <?= (!empty($sale_agent)&&$sale_agent==$result->staffid)?'selected':''; ?>><?= $result->firstname.' '.$result->lastname ?></option>
                              <?php } ?>
                              <?php } ?>
                              <?php }else{?>
                                <?php foreach ($agents as $result) { if(get_staff_user_id() ==$result->staffid){ ?>
                                <option value="<?= $result->staffid; ?>" <?= (get_staff_user_id() ==$result->staffid)?'selected':''; ?>><?= $result->firstname.' '.$result->lastname ?></option>
                              <?php } }?>
                              <?php }?>
                           </select>
                           <span id="alt3" style="color:red;"></span>
                        </div>
                       
                      
                     </div>
                  </form>
                  <div class="clearfix"></div>
                  <hr class="hr-panel-heading" />
                  <div class="clearfix"></div>
                  <?= $this->session->flashdata('statusupdate') ?>
                  <div id="failed_div"></div>
                  <div class="table-responsive" id="commission-div">
                    <table class='table' id='commission-table'>
                      <thead>
                          <tr>
                              <th>Invoice #</th>
                              <th>Link To Invoice</th>
                              <th>Amount</th>
                              <th>Record Locator(PNR)</th>
                              <th>Date</th>
                              <th>Customer</th>
                              <th>Commission</th>
                              <th>Commission Status</th>
                              <th>Agent</th>
                              <th>Ticket Number</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($commission_airlines_report)) { ?>
                        <?php foreach ($commission_airlines_report as $result) { ?>
                        <tr>
                          <td><?= $result['id']; ?></td>
                          <td><?= @$result['link_to_invoice']; ?></td>
                          <td><?= $result['total_with_symbol']; ?></td>
                          <td><?= $result['pnr']; ?></td>
                          <td><?= $result['datecreated']; ?></td>
                          <td><?= $result['customer']; ?></td>
                          <td><?= $result['commission_with_symbol']; ?></td>
                          <td class="status<?= $result['ids']; ?>"><span class='<?= $result['commission_status']=="Unpaid"?'label label-danger  s-status invoice-status-1':'label label-success  s-status invoice-status-2' ?>'><?= $result['commission_status']; ?></span></td>
                          <td><?= $result['agent']; ?></td>
                          <td><?= @$result['ticket_numbers']; ?></td>
                          <td><button type='button' onclick="myFunctions(<?= $result['ids']; ?>)" title='Update Commission Status' data-toggle='modal' data-target='#myModal' class='btn btn-default btn-with-tooltip' data-placement='bottom' data-original-title='Update Commission Status' style='margin:0px 3px !important;'> <i class='fa fa-pencil-square-o'></i></button></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                      </tbody>
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
                    </table>
                  </div>
                  <div class="table-responsive" id="commission-div1" style="display:none;">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  function myFunctions(id){
    let url = '<?= base_url(); ?>admin/airlines_report/updateStatus/'+id;
    $('#updatestatusform').attr('action',url);
    $('#commission_id').val(id);
  }
</script>

<?php init_tail(); ?>
<script type="text/javascript" id="vendor-js" src="<?= base_url(); ?>assets/builds/vendor-admin.js?v=2.4.0"></script>
<script type="text/javascript" id="jquery-migrate-js" src="<?= base_url(); ?>assets/plugins/jquery/jquery-migrate.min.js?v=2.4.0"></script>
<script type="text/javascript" id="datatables-js" src="<?= base_url(); ?>assets/plugins/datatables/datatables.min.js?v=2.4.0"></script>
<script type="text/javascript" id="moment-js" src="<?= base_url(); ?>assets/builds/moment.min.js?v=2.4.0"></script>
<script type="text/javascript" id="bootstrap-select-js" src="<?= base_url(); ?>assets/builds/bootstrap-select.min.js?v=2.4.0"></script>
<script type="text/javascript" id="tinymce-js" src="<?= base_url(); ?>assets/plugins/tinymce/tinymce.min.js?v=2.4.0"></script>
<script type="text/javascript" id="jquery-validation-js" src="<?= base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js?v=2.4.0"></script>
<script type="text/javascript" id="google-js" src="https://apis.google.com/js/api.js?onload=onGoogleApiLoad" defer></script>
<script type="text/javascript" id="common-js" src="<?= base_url(); ?>assets/builds/common.js?v=2.4.0"></script>
<script type="text/javascript" id="app-js" src="<?= base_url(); ?>assets/js/main.min.js?v=2.4.0"></script>
<script type="text/javascript" id="datatables-js" src="<?= base_url(); ?>assets/plugins/datatables/datatables.min.js?v=2.4.0"></script>
<script type="text/javascript">
  $(document).on('change','#view_agent,#commission_status',function(){
    let fromdate          = ($('#from_date').val()!='')?$('#from_date').val():'false';
    let todate            = ($('#to_date').val()!='')?$('#to_date').val():'false';
    let agents            = ($('#view_agent').val()!='')?$('#view_agent').val():'false';
    let commissionstatus  = ($('#commission_status').val()!='')?$('#commission_status').val():'false';

    let url = fromdate+'/';
     url += todate+'/';
     url += agents+'/';
     url += commissionstatus;
    window.location.href = '<?= base_url(); ?>admin/airlines_report/index/'+url;
  })
</script>
<script type="text/javascript">
$(document).on('click','#updateStatus',function(){
    $.ajax({
        url: '<?= base_url('admin/airlines_report/updateStatus');?>',
        dataType: 'json',
        type: 'post',
        data: $('#updatestatusform').serialize(),
        cache: false,
        beforeSend: function() {
            $('#updateStatus').html('<span><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');
        },
        complete: function() {
            $('#updateStatus').html('<span>Update</span>');
        },
        success: function(json) {
            $('#updateStatus').html('<span>Update</span>');
            $('.close').trigger('click');
            $('#failed_div').before('<div id="success_div"><div class="alert alert-success mymsg"><strong>Success!</strong>Commission Status Updated Successfully.</div></div>');
            if(json['status']=='Unpaid'){
                $('.status'+json['id']).html('<span class="label label-danger  s-status invoice-status-1">Unpaid</div>');
            }else{
                $('.status'+json['id']).html('<span class="label label-success  s-status invoice-status-2">Paid</div>');
            }
            
            
        }
    });
})
</script>
<script>
$(document).ready(function(){
    
setTimeout(function(){
$(".mymsg").hide();
},3000);
    

var table = $("#commission-table").DataTable({
    
   "pageLength": 25,
    "order":false,
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '<strong>$'+parseFloat(pageTotal).toFixed(2) +' ( $'+ parseFloat(total).toFixed(2) +' )</strong>'
            );
            
        }
      
        
    });
    

    
});


</script>