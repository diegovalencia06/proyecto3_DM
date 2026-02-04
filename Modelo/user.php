<?php

require_once '../Modelo/conn.php';

class user {
    
    private $db;

    public function __construct() {
        $this->db = connection();
    }

    function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
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
        $email = $data['email'];

        $password = password_hash($data['password'], PASSWORD_DEFAULT); 

        $phone = $data['telefono'] ?? null; 
        $fecha = $data['date'] ?? null;
        $fotografia = $data['fotografia'] ?? null;

        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, telefono, fecha_nacimiento, fotografia) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $password, $email, $phone, $fecha, $fotografia);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    public function getUserByGoogleId($google_id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $google_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        $stmt->close();
        return $user; 
    }

    public function updateGoogleId($email, $google_id) {
        $stmt = $this->db->prepare("UPDATE users SET google_id = ? WHERE email = ?");
        $stmt->bind_param("ss", $google_id, $email);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    public function addUserGoogle($data) {
        $username = $data['username'];
        $email = $data['email'];
        $fotografia = $data['fotografia'];
        $google_id = $data['google_id'];
        
        $password = ''; 
        
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, fotografia, google_id) VALUES (?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssss", $username, $email, $password, $fotografia, $google_id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

}