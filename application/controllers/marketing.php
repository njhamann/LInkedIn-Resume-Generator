<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/linkedin/linkedin_3.2.0.class.php');

class Marketing extends CI_Controller {

    function logout(){
        $this->session->sess_destroy();
        redirect('/', 'refresh');
    }
    
    function contact(){
        $messageSend = FALSE;
        $message = $this->input->post('message');
        if($message){
            $this->load->model('inquiry');
            $contactId = $this->inquiry->create();
            $messageSend = TRUE;
        }
        $viewData = array(
            'message_sent' => $messageSend
        );
        $this->load->view('marketing/contact', $viewData);
    }
    
    function index(){

        $API_CONFIG = $this->config->item('LINKEDIN_KEYS');
        define('DEMO_GROUP', '4010474');
        define('DEMO_GROUP_NAME', 'Simple LI Demo');
        define('PORT_HTTP', '80');
        define('PORT_HTTP_SSL', '443');
        $_REQUEST[LINKEDIN::_GET_TYPE] = isset($_REQUEST[LINKEDIN::_GET_TYPE]) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
        switch($_REQUEST[LINKEDIN::_GET_TYPE]) {
            case 'initiate':
        
                // check for the correct http protocol (i.e. is this script being served via http or https)
                if($this->input->server('HTTPS') == 'on') {
                    $protocol = 'https';
                } else {
                    $protocol = 'http';
                }
      
            // set the callback url
            $API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
            $OBJ_linkedin = new LinkedIn($API_CONFIG);
      
            // check for response from LinkedIn
            $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
            if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
                // LinkedIn hasn't sent us a response, the user is initiating the connection
        
            // send a request for a LinkedIn access token
            $response = $OBJ_linkedin->retrieveTokenRequest();
            if($response['success'] === TRUE) {
                // store the request token
               //$_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
             $response['linkedin']['request'] = $response['linkedin'];
             $this->session->set_userdata($response['linkedin']); 
                // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
                header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
            } else {
                // bad token request
                echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
            }
        } else {
            $sess = $this->session->all_userdata();
            // LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
            $response = $OBJ_linkedin->retrieveTokenAccess($sess['request']['oauth_token'], $sess['request']['oauth_token_secret'], $_GET['oauth_verifier']);
            //$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
            if($response['success'] === TRUE) {
                // the request went through without an error, gather user's 'access' tokens
                //$sess['access'] = $response['linkedin'];
                $this->session->set_userdata('access', $response['linkedin']);
                $this->session->set_userdata('authorized', TRUE);
                // set the user as authorized for future quick reference
            
                
                //save the shit to the db
                $OBJ_linkedin = new LinkedIn($API_CONFIG);
                $OBJ_linkedin->setTokenAccess($this->session->userdata('access'));
                $OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);
                $userResponse = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
                if($userResponse['success'] === TRUE) {
                    $userData = json_decode($userResponse['linkedin'], true);
                    $this->load->model('user');
                    $this->load->model('billing');
                    if(!$this->user->exist($userData['id'])){
                        $userId = $this->user->create($userData);
                        $userId = $this->billing->create(FALSE, $userId);
                        $this->session->set_userdata('user_id', $userId);
                    }else{
                        $user = $this->user->get_by_id($userData['id']); 
                        $this->session->set_userdata('user_id', $user[0]->id);
                    }
                }
                redirect('/builder/get_resume_data', 'refresh');
                // redirect the user back to the demo page
                //header('Location: ' . $_SERVER['PHP_SELF']);
            
            } else {
                echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
            }
        }
        break;

    case 'revoke':
      // check the session
      /*
      if(!$this->oauth_session_exists()) {
        throw new LinkedInException('This script requires session support, which doesn\'t appear to be working correctly.');
      }
      */
      $OBJ_linkedin = new LinkedIn($API_CONFIG);
      $OBJ_linkedin->setTokenAccess($this->session->userdata('access'));
      $response = $OBJ_linkedin->revoke();
        if($response['success'] === TRUE) {
        // revocation successful, clear session
            $this->session->sess_destroy();
            redirect('/marketing', 'refresh');
        } else {
            // revocation failed
            echo "Error revoking user's token:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
        }
            break;
            default:
	    }
        
        $isLoggedIn = (
            $this->session->userdata('authorized')) 
            ? $this->session->userdata('authorized') 
            : FALSE;
        
        if($isLoggedIn){
            redirect('/builder/get_resume_data', 'refresh');
        }
        $this->load->model('resume');
        $resumeData = $this->resume->get_by_id(1); 
        $resumeJsonData = json_encode($resumeData);
        $viewData = array(
            'isLoggedIn' => $isLoggedIn,
            'json_data' => $resumeJsonData 
        );
        $this->load->view('marketing/home', $viewData);
	}
    
    function insert_test(){
        $this->load->model('user');
        $this->user->create(); 
    }
    function pdf_test(){
    
    }
}

