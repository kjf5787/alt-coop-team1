<?php

class Student {
    private $id;
    private $email;
    private $preferredName;
    private $major;
    private $section;
    private $term;

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

    public function getSection() {
        return $this->section;
    }
    public function setSection($section) {
        $this->section = $section;
    }

    public function getTerm() {
        return $this->term;
    }
    public function setTerm($term) {
        $this->term = $term;
    }
}