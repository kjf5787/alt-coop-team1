<?php

class Student {
    private $id;
    private $email;
    private $preferredName;
    private $major;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getpreferredName() {
        return $this->preferredName;
    }
    public function setPreferredName($preferredName) {
        $this->preferredName = $preferredName;
    }

    public function getMajor() {
        return $this->major;
    }
    public function setMajor($major) {
        $this->major = $major;
    }
}