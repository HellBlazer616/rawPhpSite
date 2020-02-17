<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts()
    {
        $this->db->query("Select * from Posts");

        return  $this->db->resultSet();
    }
}
