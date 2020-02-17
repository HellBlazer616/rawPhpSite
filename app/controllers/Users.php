<?php

class Users extends Controller
{

    public function __construct()
    {
    }

    //Check for posts
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form
        } else {
            // Init data
            $data = [
                "name" => "",
                "email" => "",
                "password" => "",
                "confirm_password" => "",
                'name_err' => '',
                "email_err" => "",
                "password_err" => "",
                "confirm_password_err" => "",
            ];

            // Load View
            $this->view("users/register", $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form
        } else {
            // Init data
            $data = [
                "email" => "",
                "password" => "",
                "email_err" => "",
                "password_err" => "",
            ];

            // Load View
            $this->view("users/login", $data);
        }
    }
}
