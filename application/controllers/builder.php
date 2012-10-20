<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/linkedin/linkedin_3.2.0.class.php');

class Builder extends CI_Controller {

    function get_resume_data(){
        $this->_check_auth();
        
        $API_CONFIG = $this->config->item('LINKEDIN_KEYS');
        $OBJ_linkedin = new LinkedIn($API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->session->userdata('access'));
        $OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);
        $resumeResponse = $OBJ_linkedin->profile('~:(first-name,last-name,formatted-name,industry,skills,summary,specialties,positions,picture-url,educations,interests,headline,phone-numbers,email-address,member-url-resources)');
        
        if($resumeResponse['success'] === TRUE) {
            $resumeData = json_decode($resumeResponse['linkedin'], true);
            //print_r($resumeData);
            $this->load->model('resume');
            $userId = $this->session->userdata('user_id');
            $resumeData = Array();
            $resumeData['user_id'] = $userId;
            $resumeData['json_data'] = $resumeResponse['linkedin'];
            $resumeData['update_date'] = date('Y-m-d h:i:s');
            if(!$this->resume->exist($userId)){
                $resumeData['create_date'] = date('Y-m-d h:i:s');
                $resumeId = $this->resume->create($resumeData);
            }else{
                $resumeId = $this->resume->update_user_id($userId, $resumeData);
            }
            redirect('/builder/customize/'.$resumeId, 'refresh');
        }
    }
    
    function customize($id){
        $this->_check_auth();
        $this->load->model('resume');
        $this->load->model('resume_config');
        $resumeResults = $this->resume->get_by_id($id);
        $resumeConfigResults = $this->resume_config->get_by_resume_id($id);
        $resumeData = Array(
            'resume_config' => $resumeConfigResults,
            'user_id' => $id,
            'json_data' => json_encode($resumeResults)
        );
        $this->load->view('builder/builder', $resumeData);
    }
    
    function save_config(){
        $this->_check_auth();
        $this->load->model('resume_config');
        $resumeId = $this->input->post('resume_id');
        if(!$this->resume_config->exist($resumeId)){
            $this->resume_config->create();
        }else{
            $this->resume_config->update();
        }
        redirect('checkout', 'refresh');
    }
    
    function _is_paid_for(){
        $userId = $this->session->userdata('user_id');
        $this->load->model('billing');
        $billingData = $this->billing->get_by_user_id($userId);
        return $billingData->has_paid;
    }

    function _check_auth(){
        $isLoggedIn = (
            $this->session->userdata('authorized')) 
            ? $this->session->userdata('authorized') 
            : FALSE;
        if(!$isLoggedIn){
            redirect('/marketing', 'refresh');
        }
    }
    
}
