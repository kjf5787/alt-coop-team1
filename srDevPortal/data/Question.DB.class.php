<?php

require_once('./Question.class.php');
require_once('./DB.class.php');

class QuestionDB extends DB {

    // gets all questions from DB of a certain type (informational, personality, or technical)
    // returns an array of Question objects
    function getQuestionsByQuestionType($type){

        $query = "SELECT * FROM questions WHERE question_type = :type";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":type" => $type
            ]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Question");
            $data = $stmt->fetchAll();

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
        }

        return $data;
    }

    // gets all questions
    // returns an array of Question objects ordered by type
    function getAllQuestions(){

        $query = "SELECT * FROM questions ORDER BY question_type";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Question");
            $data = $stmt->fetchAll();

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
        }

        return $data;
    }

}