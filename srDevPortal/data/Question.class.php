<?php

class Question {
    private $id;
    private $question;
    private $question_type;
    private $input_type;
    private $name;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getQuestion() {
        return $this->question;
    }
    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getQuestionType() {
        return $this->question_type;
    }
    public function setQuestionType($questionType) {
        $this->question_type = $questionType;
    }

    public function getInputType() {
        return $this->input_type;
    }
    public function setInputType($inputType) {
        $this->input_type = $inputType;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->id = $name;
    }
}