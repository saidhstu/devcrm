<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Commission_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('contract_types_model');
    }


    public function getCommission($data=array())
    {
        //$this->db->where($data);
        if (!empty($data['fromdate'])) {
            $this->db->where('date >=', $data['fromdate']);
        }
        if (!empty($data['todate'])) {
            $this->db->where('date <=', $data['todate']);
        }
        if (!empty($data['sale_agent']) && $data['sale_agent']!='All') {
            $this->db->where('sale_agent', $data['sale_agent']);
        }
        if (!empty($data['commission_status']) && $data['commission_status']!='All') {
            $this->db->where('commission_status', $data['commission_status']);
        }

        $query = $this->db->get("tblinvoices");
        //echo $this->db->last_query();die();

        $result=$query->result();
        if (!empty($result)) {
            return $result;
        }else{
            return false;
        }
    }

    public function getTotalCommission($data=array())
    {
        $query = $this->db->get("tblinvoices");
        $result=$query->num_rows();
        if (!empty($result)) {
            return $result;
        }else{
            return false;
        }
    }
    public function getCreditnotecommission($data=array())
    {
        //$this->db->where($data);
        if (!empty($data['fromdate'])) {
            $this->db->where('date >=', $data['fromdate']);
        }
        if (!empty($data['todate'])) {
            $this->db->where('date <=', $data['todate']);
        }
        if (!empty($data['sale_agent']) && $data['sale_agent']!='All') {
            $this->db->where('agent_id', $data['sale_agent']);
        }
        if (!empty($data['commission_status']) && $data['commission_status']!='All') {
            $this->db->where('commission_status', $data['commission_status']);
        }

        $query = $this->db->get("tblcreditnotes");
        //echo $this->db->last_query();die();

        $result=$query->result();
        if (!empty($result)) {
            return $result;
        }else{
            return false;
        }
    }

    public function getTotalCreditnotecommission($data=array())
    {
        $query = $this->db->get("tblcreditnotes");
        $result=$query->num_rows();
        if (!empty($result)) {
            return $result;
        }else{
            return false;
        }
    }

    public function getAgents($data=array())
    {
        $query = $this->db->get("tblstaff");
        $result=$query->result();
        if (!empty($result)) {
            return $result;
        }else{
            return false;
        }
    }
}

