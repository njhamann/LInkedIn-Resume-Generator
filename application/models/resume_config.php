<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resume_config extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function create(){
        $resumeConfigData = array(
            'resume_id' => $this->input->post('resume_id'),
            'font' => $this->input->post('font'),
            'color_scheme' => $this->input->post('color_scheme'),
            'layout' => $this->input->post('layout'),
            'create_date' => date('Y-m-d h:i:s'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('resume_config', $resumeConfigData);
        return $this->db->insert_id();
    }
    
    function update(){
        $resumeId = $this->input->post('resume_id');
        $this->db->where('id', $resumeId);
        $resumeConfigData = array(
            'resume_id' => $resumeId,
            'font' => $this->input->post('font'),
            'color_scheme' => $this->input->post('color_scheme'),
            'layout' => $this->input->post('layout'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->update('resume_config', $resumeConfigData);
    }

    function update_user_id($userId, $resumeData){
    
        $this->db->where('user_id', $userId);
        $this->db->update('resume_config', $resumeData);
        
        $this->db->where('user_id', $userId);
        $query = $this->db->get('resume_config');
        $resumeData = $query->result();
        return $resumeData[0]->id;
    }
    
    function get_by_resume_id($resumeId){
        $this->db->where('resume_id', $resumeId);
        $query = $this->db->get('resume_config');
        $resumeResult = $query->result();
        $resumeData = $resumeResult[0];
        return $resumeData;
    } 
    
    function exist($resumeId){
        $this->db->where('resume_id', $resumeId);
        $query = $this->db->get('resume_config');
        if($query->num_rows() > 0){ 
            return TRUE; 
        } else { 
            return FALSE; 
        }
    }
}
