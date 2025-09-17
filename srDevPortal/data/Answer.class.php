<?php 

class Answer {
    private $id;
    private $question_id;
    private $answer;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getQuestionId() {
        return $this->question_id;
    }
    public function setQuestionId($question_id) {
        $this->question_id = $question_id;
    }

    public function getAnswer() {
        return $this->answer;
    }
    public function setAnswer($answer) {
        $this->answer = $answer;
    }
}