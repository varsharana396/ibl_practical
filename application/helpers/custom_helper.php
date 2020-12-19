<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_login'))
{
    function check_login()
    {
        $ci =& get_instance();

        if(!$ci->session->userdata('username')) {
            redirect('login');
        }
    }   
}