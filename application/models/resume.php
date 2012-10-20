<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resume extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function create($resumeData){
        $this->db->insert('resume', $resumeData);
        $resumeConfigData = Array(
            'resume_id' => $this->db->insert_id(),
            'create_date' => date('Y-m-d h:i:s'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('resume_config', $resumeConfigData);
        return $this->db->insert_id();
    }
    
    function update($resumeId, $resumeData){
        $this->db->where('id', $resumeId);
        $this->db->update('resume', $resumeData);
        return $resumeId;
    }

    function update_user_id($userId, $resumeData){
    
        $this->db->where('user_id', $userId);
        $this->db->update('resume', $resumeData);
        
        $this->db->where('user_id', $userId);
        $query = $this->db->get('resume');
        $resumeData = $query->result();
        return $resumeData[0]->id;
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
        $query = $this->db->get('resume');
        $resumeData = $query->result();
        $resumeData[0]->json_data = json_decode($resumeData[0]->json_data);
        return $resumeData[0];
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
