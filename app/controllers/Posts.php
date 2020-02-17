<?php

class Posts extends Controller
{
    private $postModel;
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }
    public function index()
    {
        // Get Posts
        $posts = $this->postModel->getPosts();
        $data = ["posts" => $posts];

        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            // Sanitize the post
            $sanitized_post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Get Posts
            $data = [
                "title" => trim($sanitized_post["title"]),
                'body' => trim($sanitized_post["body"]),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            // Validate Data
            if (empty($data["title"])) {
                $data["title_err"] =  "Please enter the title";
            }
            if (empty($data["body"])) {
                $data["body"] =  "A post must not be empty";
            }

            // Make sure no error
            if (empty($data["title_err"]) && empty($data["body_err"])) {
                // validated
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added');
                    redirect('posts');
                } else {
                    die("Something went wrong");
                }
            } else {
                // Load views with errors
                $this->view('posts/add', $data);
            }
        } else {

            $data = [
                "title" => "",
                'body' => "",
            ];

            $this->view('posts/add', $data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            // Sanitize the post
            $sanitized_post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Get Posts
            $data = [
                'id' => $id,
                "title" => trim($sanitized_post["title"]),
                'body' => trim($sanitized_post["body"]),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            // Validate Data
            if (empty($data["title"])) {
                $data["title_err"] =  "Please enter the title";
            }
            if (empty($data["body"])) {
                $data["body"] =  "A post must not be empty";
            }

            // Make sure no error
            if (empty($data["title_err"]) && empty($data["body_err"])) {
                // validated
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post updated');
                    redirect('posts');
                } else {
                    die("Something went wrong");
                }
            } else {
                // Load views with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            if ($post->user_id !== $_SESSION['user_id']) {
                redirect('posts');
            }

            // Check for owners
            $data = [
                'id' => $id,
                "title" => $post->title,
                'body' => $post->body,
            ];

            $this->view('posts/edit', $data);
        }
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}
