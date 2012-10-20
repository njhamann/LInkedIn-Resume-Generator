<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/linkedin/linkedin_3.2.0.class.php');
require(APPPATH.'libraries/stripe/lib/Stripe.php');
require(APPPATH.'libraries/wkhtmltopdf/wkhtmltopdf.php');

class Checkout extends CI_Controller {
    function index(){
        $this->_check_auth();
        if($this->_is_paid_for()){
            redirect('checkout/thank_you','refresh');
        }
        $userId = $this->session->userdata('user_id');
        $this->load->model('resume');
        $resumeResults = $this->resume->get_by_user_id($userId);
        $resumeData = Array(
            'user_id' => $userId,
            'json_data' => json_encode($resumeResults)
        );
        $this->load->view('checkout/checkout', $resumeData);
    }
    
    function submit_payment(){
        $this->_check_auth();
        Stripe::setApiKey('cKBoVlAfDLHAIKtDkWbbY3Lg8sz1Y0bO');
        $token = $this->input->post('stripeToken');
        $charge = Stripe_Charge::create(array(
            "amount" => 500, // amount in cents, again
            "currency" => "usd",
            "card" => $token,
            "description" => "payinguser@example.com")
        );
        $userId = $this->session->userdata('user_id');
        $this->load->model('billing');
        $this->billing->update(TRUE, $userId);
        redirect('checkout/thank_you', 'refresh');
    }
        
    function thank_you(){
        
        $this->_check_auth();
        if(!$this->_is_paid_for()){
            redirect('checkout','refresh');
        }
        $userId = $this->session->userdata('user_id');
        $this->load->model('resume');
        $resumeResults = $this->resume->get_by_user_id($userId);
        $resumeData = Array(
            'resumeId' => $resumeResults->id,
            'json_data' => json_encode($resumeResults)
        );
        $this->load->view('checkout/thank_you', $resumeData);
    }
    
    function download($resumeId){
        
        $this->_check_auth();
        if(!$this->_is_paid_for()){
            redirect('checkout','refresh');
        }
        $markup = $this->input->post('markup');

        $html = file_get_contents("http://www.google.com");
        $pdf = new WKPDF();
        //$pdf->set_html($html);
        $pdf->set_url(site_url('resumes/pdf/'.$resumeId));
        $pdf->render();
        $pdf->output(WKPDF::$PDF_EMBEDDED,'resume.pdf');        
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
