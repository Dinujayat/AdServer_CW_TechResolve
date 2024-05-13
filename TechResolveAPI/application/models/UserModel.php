<?php

class UserModel extends CI_Model
{
    // Accessing the db to insert new user data to the user table.
    public function addNewUser($data) {
        return $this->db->insert('user', $data);
    }

    // Accessing the db - checking user data
    public function loginUser($data){
        $this->db->select('*');
        $this->db->where('user_name', $data['username']);
        $this->db->where('password', $data['password']);
        $this->db->from('user');
        // to make sure only one data is accessed
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return $query->row();
        }else{
            return false;
        }
    }

}


?>