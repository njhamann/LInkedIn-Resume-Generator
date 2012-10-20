<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function create($userData){
        print_r($userData);
        $data = array(
            'linkedin_id' => $userData['id'],
            'email' => $userData['emailAddress'],
            'first_name' => $userData['firstName'],
            'last_name' => $userData['lastName'],
            'picture_url' => $userData['pictureUrl'],
            'create_date' => date('Y-m-d h:i:s'),
            'update_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
    function get_by_id($linkedinId){
        $this->db->where('linkedin_id', $linkedinId);
        $query = $this->db->get('user');
        return $query->result();
    } 

    function exist($linkedinId){
        $this->db->where('linkedin_id', $linkedinId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0){ 
            return TRUE; 
        } else { 
            return FALSE; 
        }
    }
}
