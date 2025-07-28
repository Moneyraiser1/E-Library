<?php

    interface UserInterface{
        public function Login($email, $userPassword);
         public function Register($username, $fname, $lname, $email, $userPassword, $address, $phone, $rPass);
        public function Logout();
    }