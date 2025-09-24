<?php

require_once('./Question.class.php');
require_once('./DB.class.php');

class QuestionDB extends DB {

    // gets all questions from DB of a certain type
    // returns an array of Question objects
    function getQuestionsByType($type){

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

    // inserts a question
    // returns last insert id if successful
    function insertQuestion($question, $questionType) {

        $query = "INSERT INTO questions (question, question_type) VALUES (:question, :questionType)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":question" => $question,
                ":questionType" => $questionType
            ]);

            return $this->db->lastInsertId(); // returns id if successful

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return null;
        }
    }

}