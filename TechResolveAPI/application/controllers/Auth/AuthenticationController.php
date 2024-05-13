<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthenticationController extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('UserModel');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function register(){
        // Getting the POST data being sent from the FE and validating 
        // Getting json data from the input class
        $json = $this->input->raw_input_stream;

        // decode json data, true to convert to associative array
        $data = json_decode($json, true);

        // setting up form validation rules using decoded data
        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|alpha');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        

        // If the input is valid 
        if($this->form_validation->run() == FALSE){
            // validation failed. Error sent back to client.
            $errors = validation_errors();
            $response = array(
                'status' => 'error',
                'message' => $errors
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        else{
            // If form validation passed
            // UserModel is being used to save the user data
            $userData = array(
                'first_name' => $data['fname'],
                'last_name' => $data['lname'],
                'email' => $data['email'],
                'password' => $data['password']
            );
            $this->UserModel->addNewUser($userData);
            
            // sending the success response back to client 
            $response = array(
                'status' => 'success',
                'message' => 'User Registered Successfully!'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

    }


    public function login(){

        // Getting json data from the input class
        $json = $this->input->raw_input_stream;

        // Decode json data, true to convert to associative array
        $data = json_decode($json, true);

        // Setting up form validation rules using decoded data
        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('username', 'User Name', 'trim|required|alpha');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        
        if($this->form_validation->run() == FALSE){
            // validation failed. Error sent back to client.
            $errors = validation_errors();
            $response = array(
                'status' => 'error',
                'message' => $errors
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        else
        {
            $data = array(
                'username' => $data['username'],
                'password' => $data['password']
            );
            $result = $this->UserModel->loginUser($data); 
            //checks if the db has these user credential.
            if($result != FALSE){

                // storing the data of the successfully logged in user
                $authUserData = [
                    'first_name' => $result->first_name,
                    'last_name' => $result->last_name,
                    'email' => $result->email,
                ];
                // session make
                // user -> 1, admin -> 2
                $this->session->set_userdata('authenticated', $result->role);
                $this->session->set_userdata('auth_user', $authUserData);

                // sending the success response back to client 
                $response = array(
                    'status' => 'success',
                    'message' => 'User LoggedIn Successfully!'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            else
            {
                $response = array(
                    'status' => 'error',
                    'message' => 'no such user!'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));    
            }
        }
    }

    // whether user is loggedin 
    public function isLoggedIn(){
        // checks whether the already logged in user is authenticted 
        if($this->session->userdata('authenticated')){
            if($this->session->userdata('authenticated') == 1 ){
                $dataOfUser = $this->session->userdata('auth_user');
                $response = array(
                    'loggedIn' => true,
                    'loggedAs' => 'GeneralUser',
                    'username' => $dataOfUser['first_name']
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
        }
        else
            {
                $response = array(
                    'loggedIn' => false,
                    'loggedAs' => 'PublicUser'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
    }

    // to check if use is admin
    public function isAdmin(){
        if($this->session->has_userdata('authenticated')){
            if($this->session->userdata('authenticated') != '2')
            {
                $response = array(
                    'status' => 'error',
                    'message' => 'Access Denied. Not Admin!'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));    
            }
            else{
                $response = array(
                    'status' => 'success',
                    'message' => 'Access granted.'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));    
            }
        }
    }

    public function logout(){
        // session data is being destroyed / unset
        $this->session->unset_userdata('authenticated');
        $this->session->unset_userdata('auth_user');
        $response = array(
            'status' => 'success',
            'message' => 'Logged Out!'
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($response));    
    
    }

}


?>