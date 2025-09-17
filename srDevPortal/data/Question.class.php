<?php

class Question {
    private $id;
    private $question;
    private $questionType;

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
        return $this->questionType;
    }
    public function setQuestionType($questionType) {
        $this->questionType = $questionType;
    }
}