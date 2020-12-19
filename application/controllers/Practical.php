<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Practical extends CI_Controller {

    function __construct()
	{
		parent::__construct();
     
        $this->load->model('Practical_model','_PracticalRepository');
        $allowed = array(
            'index',
            'login'
			
		);
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
            check_login();
        }
        
    }
    
    public function logout()
    {
        if($this->session->userdata('username')) {
            $this->session->unset_userdata('username');
            
        }
        redirect('login');
    }

	public function index()
	{

        if(!$this->session->userdata('username')) {
            $this->load->view('login');
        } else{
            // $this->session->unset_userdata('username');
            redirect('appointment');
        }
    }
    public function login()
    {
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'You must provide a %s.',
                ),
            ),
		);
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<div class="err">', '</div>');
		if($this->form_validation->run() == false) {
			
			$errors = array();
                // Loop through $_POST and get the keys
                foreach ($this->input->post() as $key => $value)
                {
                    // Add the error message for this field
                    $errors[$key] = form_error($key);
				}
				$response['errors'] = array_filter($errors); // Some might be empty
                $response['status'] = FALSE;
                echo json_encode($response);
		} else {

			if($this->input->post('password')=='123' && $this->input->post('username')=='varsha@gmail.com') {
                if(!$this->session->userdata('username')) {
                    $this->session->set_userdata('username', $this->input->post('username'));
                }
                $response['success'] = 1;
                echo json_encode($response);
            } else {
                $response['errors'] = 'UserName or Password is wrong'; // Some might be empty
                $response['status'] = FALSE;
                $response['login_error'] = 1;
                echo json_encode($response);
            }
		}
    }
    public function appointment_index()
    {
        $data['data'] = $this->_PracticalRepository->get_app_data($this->session->userdata('username'));
        //print_r($data);
        $this->load->view('Appointment/index',$data);
    }
    public function app_add()
    {
        $data['hospitals'] = $this->_PracticalRepository->get_data_by_ref_id('hospital',array('Is_delete'=>0));
        $data['departments'] = $this->_PracticalRepository->get_data_by_ref_id('department',array('Is_delete'=>0));
        $this->load->view('Appointment/add',$data);
    }
    public function app_store()
    {
        
        $config = array(
            array(
                'field' => 'Department_ID',
                'label' => 'Department',
                'rules' => 'required'
            ),
            array(
                'field' => 'Hospital_ID',
                'label' => 'Hospital',
                'rules' => 'required',
            ),
            array(
                'field' => 'Appointment_date',
                'label' => 'Appointment_date',
                'rules' => 'required',
            ),
            array(
                'field' => 'Appointment_time',
                'label' => 'Appointment_time',
                'rules' => 'required',
            ),
		);
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<div class="err">', '</div>');
		if($this->form_validation->run() == false) {
			
			$errors = array();
                // Loop through $_POST and get the keys
                foreach ($this->input->post() as $key => $value)
                {
                    // Add the error message for this field
                    $errors[$key] = form_error($key);
				}
				$response['errors'] = array_filter($errors); // Some might be empty
                $response['status'] = FALSE;
                echo json_encode($response);
        } else {
            $data = $this->input->post();
            $data['Is_delete']=0;
            $check_app = $this->_PracticalRepository->check_app_availability($data);
            if(count($check_app)) {
                $response['errors'] = 'Select another date and time'; // Some might be empty
                $response['status'] = FALSE;
                $response['app_error'] = 1;
                echo json_encode($response);
            } else {
                
                $data['Created_at'] = date('Y-m-d H:i:s');
                $data['User_email'] = $this->session->userdata('username');
                $this->_PracticalRepository->insert_entry('appointment',$data);
                $response['success'] = 1;
                echo json_encode($response);
            }

        }
        
    }

    public function delete_app($id)
    {
        $data=array(
            'Is_delete'=>1
        );
        $where=array(
            'Id'=>$id
        );
        $result=$this->_PracticalRepository->update_data($data,$where,'appointment');
        if($result){
            redirect('appointment');
        }
    }
}
