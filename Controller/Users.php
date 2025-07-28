<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../vendor/autoload.php';
require_once '../Model/Database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Users {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    private function validateName($name) {
        return !preg_match('/[0-9]/', $name);
    }

    public function Login($email, $userPassword) {
        if (empty($email) || empty($userPassword)) {
            $_SESSION['msg'] = 'Fields cannot be empty';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        $this->db->query('SELECT * FROM user WHERE email = :em');
        $this->db->bind(':em', $email);
        $row = $this->db->singleRecord();

        if ($row && password_verify($userPassword, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['role_as'] = $row['role_as'];
            $_SESSION['lname'] = $row['lname'];

            if ($row['role_as'] == "admin") {
                $_SESSION['msg'] = 'Welcome admin';
                $_SESSION['msg_type'] = 'success';
                header('Location: ../admin/aDashboard');
                exit();
            } elseif ($row['role_as'] == "user") {
                $_SESSION['msg'] = 'Welcome, logged in successfully';
                $_SESSION['msg_type'] = 'success';
                header('Location: ../user/index');
                exit();
            } else {
                $_SESSION['msg'] = 'Unknown role';
                $_SESSION['msg_type'] = 'error';
                return false;
            }
        }else{
             $_SESSION['msg'] = 'Wrong Credentials';
                $_SESSION['msg_type'] = 'error';
                      header('Location: ../auth/login');
                return false;
        }

        $_SESSION['msg'] = 'Invalid credentials';
        $_SESSION['msg_type'] = 'error';
        return false;
    }

    public function Register($username, $fname, $lname, $email, $userPassword, $address, $phone, $rPass) {
        // Validate required fields
        if (
            empty($username) || empty($fname) || empty($lname) ||
            empty($email) || empty($userPassword) || empty($rPass) ||
            empty($address) || empty($phone)
        ) {
            $_SESSION['msg'] = 'Fields cannot be empty';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        if ($userPassword !== $rPass) {
            $_SESSION['msg'] = 'Passwords do not match';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        if (!$this->validateName($fname) || !$this->validateName($lname)) {
            $_SESSION['msg'] = "First name or Last name should not contain numbers";
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['msg'] = "Invalid email format!";
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        if (!preg_match('/^\d{11}$/', $phone)) {
            $_SESSION['msg'] = 'Phone number must be 11 digits';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Check if user exists by phone or email
        $this->db->query("SELECT * FROM user WHERE phone=:ph OR email=:em");
        $this->db->bind(':ph', $phone);
        $this->db->bind(':em', $email);
        $row = $this->db->singleRecord();
        if ($row) {
            $_SESSION['msg'] = "User already in Records";
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        $this->db->query('INSERT INTO user(fname, lname, username, password, phone, email, verification_token, is_verified, address) VALUES(:fn, :ln, :un, :pw, :ph, :em, :token, 0, :ad)');
        $this->db->bind(':fn', $fname);
        $this->db->bind(':ln', $lname);
        $this->db->bind(':un', $username);
        $this->db->bind(':pw', $hashedPassword);
        $this->db->bind(':ph', $phone);
        $this->db->bind(':em', $email);
        $this->db->bind(':token', $token);
        $this->db->bind(':ad', $address);

        if ($this->db->execute()) {
            $this->sendVerificationEmail($email, $fname, $token);
            $_SESSION['msg'] = "Registration successful! Please verify your email.";
            $_SESSION['msg_type'] = 'success';
            return true;
        } else {
            $_SESSION['msg'] = "Registration failed. Try again.";
            $_SESSION['msg_type'] = 'error';
            return false;
        }
    }

    private function sendVerificationEmail($email, $fname, $token) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
           // $mail->Username   = 'Insert your username here preferably your gmail';
           // $mail->Password   = 'insert your gmail password here';
            /$mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //$mail->setFrom('insert your gmail here', 'Library System');
            $mail->addAddress($email, $fname);

            $mail->isHTML(true);
            $mail->Subject = 'Verify your email address';
            $verificationLink = "http://localhost/Library-management-system/verify?token=$token";
            $mail->Body    = "Hello $fname,<br>Please verify your email by clicking the link below:<br><a href='$verificationLink'>$verificationLink</a>";

            $mail->send();
        } catch (Exception $e) {
            // Optionally log error
        }
    }

    public function verifyEmail() {
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $_SESSION['msg'] = "Invalid or missing verification token.";
            $_SESSION['msg_type'] = "error";
            header("Location: /auth/login");
            exit;
        }

        $token = $_GET['token'];
        $this->db->query("SELECT * FROM user WHERE verification_token = :token AND is_verified = 0");
        $this->db->bind(':token', $token);
        $user = $this->db->singleRecord();

        if ($user) {
            $this->db->query("UPDATE user SET is_verified = 1, verification_token = NULL WHERE id = :id");
            $this->db->bind(':id', $user['id']);
            if ($this->db->execute()) {
                $_SESSION['msg'] = "Email verified successfully.";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['msg'] = "Verification failed. Try again.";
                $_SESSION['msg_type'] = "error";
            }
        } else {
            $_SESSION['msg'] = "Invalid or expired token.";
            $_SESSION['msg_type'] = "error";
        }

        header("Location: /auth/login");
        exit;
    }

    public function Logout() {
        session_unset();
        session_destroy();
    }

    public function showUsers() {
        $this->db->query('SELECT * FROM user WHERE role_as = "user" ORDER BY created_at DESC');
        $rows = $this->db->resultSet();
        return $rows ?: false;
    }

    public function remove($id) {
        $this->db->query('DELETE FROM user WHERE id=:uid');
        $this->db->bind(':uid', $id);

        if ($this->db->execute()) {
            $_SESSION['msg'] = 'User removed successfully';
            $_SESSION['msg_type'] = 'success';
            header('Location: ../admin/userManagement');
            exit();
        } else {
            $_SESSION['msg'] = 'Failed to remove user';
            $_SESSION['msg_type'] = 'error';
            return false;
        }
    }

    public function changePassword($id, $fname, $lname, $username, $email, $phone, $oldPass, $newPass, $rPass) {
        $this->db->query("SELECT * FROM user WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRecord();

        if (!$row) {
            return "User not found!";
        }

        if (!password_verify($oldPass, $row['password'])) {
            return "Old password is incorrect!";
        }

        if ($newPass !== $rPass) {
            return "New passwords do not match!";
        }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['msg'] = "Invalid email format!";
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        if (!preg_match('/^\d{11}$/', $phone)) {
            $_SESSION['msg'] = 'Phone number must be 11 digits';
            $_SESSION['msg_type'] = 'error';
            return false;
        }
            if (!$this->validateName($fname) || !$this->validateName($lname)) {
            $_SESSION['msg'] = "First name or Last name should not contain numbers";
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

        $this->db->query("UPDATE user SET fname=:fn, lname=:ln, username=:un, phone=:ph, password=:newpass WHERE id=:id");
        $this->db->bind(':fn', $fname);
        $this->db->bind(':ln', $lname);
        $this->db->bind(':un', $username);
        $this->db->bind(':ph', $phone);
        $this->db->bind(':newpass', $hashedPass);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            return true;
        } else {
            return "Failed to update password.";
        }
    }

    public function showAdmin() {
        $this->db->query('SELECT * FROM user WHERE role_as = "admin" ORDER BY created_at DESC');
        $rows = $this->db->resultSet();
        return $rows ?: false;
    }
    public function getTotalUsers() {
    $this->db->query("SELECT COUNT(*) as total FROM user WHERE role_as = 'user'");
    $row = $this->db->singleRecord();
    return $row['total'] ?? 0;
}
public function getBookDownloadStats() {
    $this->db->query("
        SELECT b.title AS book_title, COUNT(d.id) AS total_downloads
        FROM downloads d
        JOIN books b ON d.book_id = b.id
        GROUP BY b.title
        ORDER BY total_downloads DESC
        LIMIT 6
    ");
    return $this->db->resultSet();
}

}
