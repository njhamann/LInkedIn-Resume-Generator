<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function create($hasPaid, $userId){
        $billingData = Array(
            'user_id' => $userId,
            'has_paid' => $hasPaid,
            'create_date' => date('Y-m-d h:i:s'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('billing', $billingData);
        return $this->db->insert_id();
    }
    
    function update($hasPaid, $userId){
        $this->db->where('user_id', $userId);
        $billingData = Array(
            'user_id' => $userId,
            'has_paid' => $hasPaid,
            'create_date' => date('Y-m-d h:i:s'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->update('billing', $billingData);
    }

    
    function get_by_id($resumeId){
        $this->db->where('id', $resumeId);
        $query = $this->db->get('resume');
        $resumeData = $query->result();
        $resumeData[0]->json_data = json_decode($resumeData[0]->json_data);
        return $resumeData[0];
    } 
    
    function get_by_user_id($userId){
        $this->db->where('user_id', $userId);
        $query = $this->db->get('billing');
        $billingResult = $query->result();
        $billingData = $billingResult[0];
        return $billingData;
    } 
    
    function exist($userId){
        $this->db->where('user_id', $userId);
        $query = $this->db->get('resume');
        if($query->num_rows() > 0){ 
            return TRUE; 
        } else { 
            return FALSE; 
        }
    }
}
