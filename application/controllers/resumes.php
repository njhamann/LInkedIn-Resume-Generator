<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resumes extends CI_Controller {
    function index(){
        $this->_check_auth();
        if($this->_is_paid_for()){
            redirect('checkout/thank_you','refresh');
        }
    }
    
    function pdf($resumeId){
    /*
        $this->_check_auth();
        if(!$this->_is_paid_for()){
            redirect('checkout','refresh');
        }
      */
        $userId = $this->session->userdata('user_id');
        $this->load->model('resume');
        $resumeResults = $this->resume->get_by_id($resumeId);
        $resumeData = Array(
            'user_id' => $userId,
            'json_data' => json_encode($resumeResults)
        );
        
        $this->load->view('resume/pdf', $resumeData);
    }
        
    function view(){
        $this->load->view('resume/view');
    }
    
    function options(){
        $this->load->view('resume/options');
    }
    
    function _is_paid_for(){
        $userId = $this->session->userdata('user_id');
        $this->load->model('billing');
        $billingData = $this->billing->get_by_user_id($userId);
        return $billingData->has_paid;
    }
    
    function _check_auth(){
        session_start(); 
        $isLoggedIn = (
            $this->session->userdata('authorized')) 
            ? $this->session->userdata('authorized') 
            : FALSE;
        if(!$isLoggedIn){
            redirect('/marketing', 'refresh');
        }
    }
}
