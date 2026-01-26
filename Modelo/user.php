<?php

require_once '../Modelo/conn.php';

class user {
    
    private $db;

    public function __construct() {
        $this->db = connection();
    }

    function getUserByUsername($username) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row;
        } else {
            $stmt->close();
            return null;
        }
    }

    function userExists($username) {

        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        $existe = $stmt->num_rows > 0;
        
        $stmt->close();
        return $existe;

    }

    public function emailExists($email) {

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        $existe = $stmt->num_rows > 0;
        
        $stmt->close();
        return $existe;

    }

    public function addUsers($data) {
        $username = $data['username'];
        $email    = $data['email'];

        $password = password_hash($data['password'], PASSWORD_DEFAULT); 

        $phone    = $data['telefono'] ?? null; 
        $fecha      = $data['date'] ?? null;

        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, telefono, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $email, $phone, $fecha);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }



}