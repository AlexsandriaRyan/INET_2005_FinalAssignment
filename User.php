<?php

class User {

    public $fname;
    public $lname;
    public $phone;
    public $username;
    public $password;

    public function __construct($fname, $lname, $phone,$username, $password) {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->phone = $phone;
        $this->username = $username;
        $this->password = $password;
    }
}