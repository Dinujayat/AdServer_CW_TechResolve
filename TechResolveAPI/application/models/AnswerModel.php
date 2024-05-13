<?php

class AnswerModel extends CI_Model
{
    // Accessing the db to insert new answer
    public function addNewAnswer($data) {
        return $this->db->insert('answer', $data);
    }

    // To fetch answer for a question 
    public function getanswerForQuestion($question_id){
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('answer');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
        
    }

    // Deleting the answer with the given ans id
    public function deleteAnswer($answer_id){
        $this->db->where('answer_id', $answer_id);
        return $this->db->delete('answer');
    }

    // For udating existing answers in the db
    public function updateAnswer($data){
        $this->db->where('answer_id', $data['answer_id']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('question_id', $data['question_id']);

        return $this->db->update('answer', $data);
    }

}


?>