<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 

defined('BASEPATH') or exit('No direct script access allowed');

class Airlines_report extends AdminController
{
  public function __construct()
    {
      parent::__construct();
      $this->load->model('Commission_model');
    }
    /* In case if user go only on /commission */

    function index($fromdate='',$todate='',$agents='',$commissionstatus='')
    {

      $data = array();
      if ($fromdate!='false') {
        $data['fromdate'] = $fromdate;
      }
      if ($todate!='false') {
        $data['todate'] = $todate;
      }
      if ($agents!='false') {
        $data['sale_agent'] = $agents;
      }
      if ($commissionstatus!='false' && $commissionstatus!='undefined') {
        $data['commission_status'] = $commissionstatus;
      }

      if(!is_admin()){
        $data['sale_agent'] = get_staff_user_id();
      }

      //credit note commission
      $commission_infos = $this->Commission_model->getCreditnotecommission($data);


      $data['agents']     = $this->Commission_model->getAgents();
      $data['commission_notes'] = array();
      if (!empty($commission_infos)) {
          $total_invoice=0;
          foreach ($commission_infos as $result) {
             $total_invoice++;
             $id = sprintf('%06d',$result->number);
             $ids = $result->id;
             $prefix = $result->prefix;
             $date = date("Y",strtotime($result->date));
             $invoice = $prefix.$date."/".$id;
             
             $total = $result->total;

             $this->db->where('userid',$result->clientid);
             $query11 = $this->db->get('tblclients');
             $result11=$query11->row_array();
             $customer = !empty($result11['company'])?$result11['company']:'';

             $this->db->where('id',$result->currency);
             $query1 = $this->db->get('tblcurrencies');
             $result1=$query1->row_array();
             $symbol = $result1['symbol'];
             $total_with_symbol = !empty($result1['symbol'])?$result1['symbol'].sprintf("%.2f", $total):'';

             $this->db->where('staffid',$result->agent_id);
             $query2 = $this->db->get('tblstaff');
             $result2=$query2->row_array();
             $agent = !empty($result2['firstname'])?$result2['firstname'].' '.$result2['lastname']:'';

             $this->db->where(array('relid' => $result->id,'fieldid' => '13'));
             $query4 = $this->db->get('tblcustomfieldsvalues');
             $result4=$query4->row_array();
             
            $commission = !empty($result4["value"])?$result4["value"]:0;
            $commission_with_symbol = $symbol.sprintf("%.2f", $commission);
            if($commission=="")
            $commission_with_symbol = sprintf("%.2f", $commission);
            else
            $commission_with_symbol = $symbol.sprintf("%.2f", $commission);

             $data['commission_notes'][$ids] = array(
                  'id'                        => $id,
                  'total_with_symbol'         => $total_with_symbol,
                 'pnr'                       => @$pnr,
                  'datecreated'               => date("Y-m-d",strtotime($result->date)),
                  'customer'                  => $customer,
                  'commission_with_symbol'    => $commission_with_symbol,
                  'commission_status'         => $result->commission_status,
                  'reference_no'         => $result->reference_no,
                  'reference_number'         => intval($result->reference_no),
                  'agent'                     => $agent,
                  'ids'                       => $ids,
              );
          }
      }

      //invoice airlines report
      
        $commission_infos = $this->Commission_model->getCommission($data);

        $data['agents']     = $this->Commission_model->getAgents();
        $data['commission_airlines'] = array();
        if (!empty($commission_infos)) {
            $total_invoice=0;
            foreach ($commission_infos as $result) {

                $this->db->where('rel_id',$result->id);
                $this->db->where('rel_type','invoice');
                $iteminfo =$this->db->get('tblitemable');
                $iteminfo = $iteminfo->result_array();
                $ticketns = array();
                foreach ($iteminfo as $key => $tresult) {
                        //print_r($result['rel_id']);die();
                    $this->db->where('relid',$tresult['id']);
                    $this->db->where('fieldid','11');
                    $this->db->where('fieldto','items');
                    $iteminfo2 =$this->db->get('tblcustomfieldsvalues');
                    $iteminfo2 = $iteminfo2->result_array();
                    foreach ($iteminfo2 as $key => $tresult2) {
                        $ticketns[] = $tresult2['value'];
                    }
                }
                
                $ticketnumbers = implode('<br/>',$ticketns);

    
            $total_invoice++;
            $id = sprintf('%06d',$result->number);
            $ids = $result->id;
            $prefix = $result->prefix;
            $date = date("Y",strtotime($result->date));
            $invoice = $prefix.$date."/".$id;
            
            $total = $result->total;

            $this->db->where('userid',$result->clientid);
            $query11 = $this->db->get('tblclients');
            $result11=$query11->row_array();
            $customer = !empty($result11['company'])?$result11['company']:'';

            $this->db->where('id',$result->currency);
            $query1 = $this->db->get('tblcurrencies');
            $result1=$query1->row_array();
            $symbol = $result1['symbol'];
            $total_with_symbol = !empty($result1['symbol'])?$result1['symbol'].sprintf("%.2f", $total):'';

            $this->db->where('staffid',$result->sale_agent);
            $query2 = $this->db->get('tblstaff');
            $result2=$query2->row_array();
            $agent = !empty($result2['firstname'])?$result2['firstname'].' '.$result2['lastname']:'';

            $this->db->where(array('relid' => $result->id,'fieldid' => '7'));
            $query3 = $this->db->get('tblcustomfieldsvalues');
            $result3=$query3->row_array();
            $pnr = !empty($result3['value'])?$result3['value']:'';

            $this->db->where(array('relid' => $result->id,'fieldid' => '1'));
            $query4 = $this->db->get('tblcustomfieldsvalues');
            $result4=$query4->row_array();
            
            $commission = !empty($result4["value"])?$result4["value"]:0;
            $commission_with_symbol = $symbol.sprintf("%.2f", $commission);
            if($commission=="")
            $commission_with_symbol = sprintf("%.2f", $commission);
            else
            $commission_with_symbol = $symbol.sprintf("%.2f", $commission);
                                    
            //$commission_with_symbol = !empty($result4['value'])?$symbol.sprintf("%.2f", $result4['value']):sprintf("%.2f", $result4['value']);
            $data['commission_airlines'][$ids] = array(
                'id'                        => $id,
                'ticket_numbers'         => $ticketnumbers,
                'total_with_symbol'         => $total_with_symbol,
                'pnr'                       => $pnr,
                'datecreated'               => date("Y-m-d",strtotime($result->date)),
                'customer'                  => $customer,
                'commission_with_symbol'    => $commission_with_symbol,
                'commission_status'         => $result->commission_status,
                'agent'                     => $agent,
                'ids'                       => $ids,
            );
        }
        }

        $insert_airlines_ids = [];
        $commission_airlines_report = [];
        $notes_reference = array_column($data['commission_notes'], 'reference_number', 'ids');
        foreach($data['commission_airlines'] as $key => $value){

          // echo "<br><br>".'airlines = '. $value['id']."<br>";
          $invoice_no = intval($value['id']);
          $commission_airlines_report[] = $value;

          foreach( $data['commission_notes'] as $keyId => $notes){
            // echo 'notes = '. $notes['id']."<br>";
            if( $invoice_no == intval($notes['reference_number'])){
            
              $notes['link_to_invoice'] = $value['id'];
              $commission_airlines_report[] = $notes;
              $insert_airlines_ids[] = $notes['ids'];
            }
          }
        }

        $all_commission_notes_ids = array_column($data['commission_notes'], 'ids');

        foreach( $data['commission_notes'] as $keyId => $notes){
          // echo 'notes = '. $notes['id']."<br>";
          if( !in_array($notes['id'], $insert_airlines_ids)){
          
            $commission_airlines_report[] = $notes;
          }
        }
  
        $data['commission_airlines_report'] = $commission_airlines_report;
        // echo"<pre>";print_r($data['commission_notes']);
        // echo"<pre>";print_r($data['commission_airlines']);
        // echo"<pre>";print_r($data['commission_airlines_report']);
        // die();
        $this->load->view('admin/airlines/airlines_report',$data);
    }

    

    public function updateStatus($id=''){
        if(!empty($this->input->post('commission_id'))){
            $id = $this->input->post('commission_id');
        }
        $json = array();
        $this->db->where('id',$id);
        $this->db->update('tblinvoices',array('commission_status' => $this->input->post('commissionstatus')));
        $this->session->set_flashdata('statusupdate', '<div id="success_div"><div class="alert alert-success mymsg"><strong>Success!</strong>Commission Status Updated Successfully.</div></div>');
        //redirect(base_url().'admin/commission');
        $json['success'] = 'success';
        $json['status'] = $this->input->post('commissionstatus');
        $json['id'] = $id;
        header('Content-Type: application/json');
        echo json_encode($json);
    } 


    function commission_status()

    {

        $invoice_id = $_POST['invoice_id'];

        

        $this->load->view('admin/commission/get_commission_status');

    }



    function update_commission_status()

    {

        $invoice_id = $_POST['invoice_id'];

        $commission_status = $_POST['commission_status'];

        

        $this->load->view('admin/commission/get_update_commission_status');

    }

    

    function get_commission()

    {

        $commission_report = $_POST['commission_report'];

        

        $this->load->view('admin/commission/get_view_commission_report');

    }

    

    function get_commission_data()

    {

        $commission_status = $_POST['commission_status'];

        $from_date = $_POST['from_date'];

        $to_date = $_POST['to_date'];

        $view_agent = $_POST['view_agent'];

        

        $this->load->view('admin/commission/get_view_commission_report_data');

    }



}

