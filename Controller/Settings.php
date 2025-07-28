<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../Model/Database.php";
class Settings {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getUserById($id){
        $this->db->query("SELECT * FROM user WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->singleRecord();
    }
      public function getSettings() {
        $this->db->query("SELECT * FROM settings LIMIT 1");
        return $this->db->singleRecord();
    }


   public function updateAdminProfile($userId, $fname, $email, $password = null, $image = null) {
    $query = "UPDATE user SET fname = :fname, email = :email";
    if ($password) {
        $query .= ", password = :password";
    }
    if ($image) {
        $query .= ", image = :image";
    }
    $query .= " WHERE id = :id";

    $this->db->query($query);
    $this->db->bind(':fname', $fname);
    $this->db->bind(':email', $email);
    if ($password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $this->db->bind(':password', $hashed);
    }
    if ($image) {
        $this->db->bind(':image', $image);
    }
    $this->db->bind(':id', $userId);

    return $this->db->execute();
}

    public function updateSettings($library_name, $download_limit, $logo = null) {
        $query = "UPDATE settings SET library_name = :library_name, 
                  download_limit = :download_limit";
        if ($logo) {
            $query .= ", logo = :logo";
        }
        $query .= " WHERE id = 1";

        $this->db->query($query);
        $this->db->bind(':library_name', $library_name);
        $this->db->bind(':download_limit', $download_limit);
        if ($logo) {
            $this->db->bind(':logo', $logo);
        }
        return $this->db->execute();
    }
}


