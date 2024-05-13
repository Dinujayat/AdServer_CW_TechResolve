<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerController extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('AnswerModel');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // End point for adding a new answer 
    public function postAnswer(){
        // get the POST data from the FE

        // Getting json data from the input class
        $json = $this->input->raw_input_stream;

        // decode json data, true to convert to associative array
        $data = json_decode($json, true);

        // setting up input validation for the availability of an answer
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('answer', 'Answer', 'trim|required');
        
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
            $answerDetails = array(
                'user_id' => $data['userId'],
                'question_id' => $data['questionId'],
                'answer_body' => $data['answer']
            );
            $dbResponse = $this->AnswerModel->addNewAnswer($answerDetails);
    
            // sending response to the user
            // if OK
            if($dbResponse){
                $response = array(
                    'status' => 'Success',
                    'message' =>'answer added!'
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


    // End point for fetching all the answers for a question
    public function answerForQuestion(){
        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);
        $answers = $this->AnswerModel->getanswerForQuestion($data['questionId']);
        if($answers){
            $this->output->set_content_type('application/json')->set_output(json_encode($answers));    
        }else{
            $response = array(
                'status' => 'Error',
                'message' =>'Unable to retreive.'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response));    
        }
    }


    // To drop a question - delete
    public function removeAnswer(){
        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);
        $success = $this->AnswerModel->deleteAnswer($data['answerId']);
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

    // End point for updating the selected answer
    public function editAnswer(){
        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);

        // should rearrange the data being received to one obj
        $answerData = array(
            'answer_id' => $data['answerId'],
            'user_id' => $data['userId'],
            'question_id' => $data['questionId'],
            'answer_body' => $data['answer']
        );

        $success = $this->AnswerModel->updateAnswer($answerData);
        if($success){
            $response = array(
                'status' => 'Success',
                'message' => "Answer Updated!"
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