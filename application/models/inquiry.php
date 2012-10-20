<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function create(){
        $contactData = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'type' => $this->input->post('type'),
            'message' => $this->input->post('message')
        );
        $this->db->insert('contact', $contactData);
        return $this->db->insert_id();
    }
}
