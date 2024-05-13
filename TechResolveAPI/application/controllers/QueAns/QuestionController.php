<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionController extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('QuestionModel');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // End point for adding a new question 
    public function postQuestion(){
        // get the POST data from the FE

        // Getting json data from the input class
        $json = $this->input->raw_input_stream;

        // decode json data, true to convert to associative array
        $data = json_decode($json, true);

        // setting up input validation for the availability of a title
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('questionTitle', 'Title', 'trim|required');
        
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
            $questionDetails = array(
                'user_id' => $data['userId'],
                'question_title' => $data['questionTitle'],
                'question_body' => $data['questionBody']
            );
            $dbResponse = $this->QuestionModel->addNewQuestion($questionDetails);
    
            // sending response to the user
            // if OK
            if($dbResponse){
                $response = array(
                    'status' => 'Success',
                    'message' =>'question added'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));    
            }else{
                $response = array(
                    'status' => 'Error',
                    'message' =>'Unable to add.'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response));    
            }
        }
    }


    // End point for fetching all the questions
    public function allQuestions(){
        $questions = $this->QuestionModel->getAllQuestions();
        if($questions){
            $this->output->set_content_type('application/json')->set_output(json_encode($questions));    
        }else{
            $response = array(
                'status' => 'Error',
                'message' =>'Unable to retreive.'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }
    }


    // To drop a question - delete
    public function removeQuestion(){
        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);
        $success = $this->QuestionModel->deleteQuestion($data['questionId']);
        if($success){
            $response = array(
                'status' => 'Success',
                'message' => $success
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }else{
            $response = array(
                'status' => 'Error',
                'message' =>'Unable to delete'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }
    }

    // End point for updating the selected question 
    public function updateQuestion(){
        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);

        // should rearrange the data being received to one obj
        $questionData = array(
            'user_id' => $data['userId'],
            'question_title' => $data['questionTitle'],
            'question_body' => $data['questionBody']
        );

        $success = $this->QuestionModel->updateQuestion($data['questionId'], $questionData);
        if($success){
            $response = array(
                'status' => 'Success',
                'message' => "Question Updated!"
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }else{
            $response = array(
                'status' => 'Error',
                'message' =>'Unable to update'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }
    }

}

?>