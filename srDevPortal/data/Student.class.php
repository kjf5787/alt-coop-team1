<?php

class Student {
    private $id;
    private $firstName;
    private $lastName;
    private $preferredName;
    private $major;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }
    public function setLastName($lastName) {
        $this->lastName = $lastName;
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