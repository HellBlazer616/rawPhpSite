<?php

class Pages extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        if (isLoggedIn()) {
            redirect('posts');
        }
        $data = [
            'title' => 'SharePosts',
            'description' => "Simple Social Network built of OOP MVC"
        ];

        $this->view('pages/index', $data);
    }

    public function about()
    {

        $data = [
            'title' => 'SharePosts',
            'description' => "Sharing is Caring. So, share but don't overshare"
        ];
        $this->view('pages/about', $data);
    }
}
