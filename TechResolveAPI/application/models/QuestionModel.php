<?php

class QuestionModel extends CI_Model
{
    // Accessing the db to insert new question
    public function addNewQuestion($data) {
        return $this->db->insert('question', $data);
    }

    // To fetch all of the questions in db 
    public function getAllQuestions(){
        $query = $this->db->get('question');
        return $query->result();
    }

    // Deleting the question with the given q id
    public function deleteQuestion($question_id){
        $this->db->where('id', $question_id);
        return $this->db->delete('question');
    }


    // For udating existing questions in the db
    public function updateQuestion($question_id, $data){
        $this->db->where('id', $question_id);
        return $this->db->update('question', $data);
    }

}


?>