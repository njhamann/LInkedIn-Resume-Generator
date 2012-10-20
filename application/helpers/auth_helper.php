<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function is_logged_in() {
          // Get current CodeIgniter instance
        $CI =& get_instance();
                  // We need to use $CI->session instead of $this->session
        $isAuthed = $CI->session->userdata('authorized');
        if ($isAuthed) { 
            return false; 
        } else { 
            return true; 
        }
    }
