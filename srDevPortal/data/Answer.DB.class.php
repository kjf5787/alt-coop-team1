<?php

require_once __DIR__ . '/Answer.class.php';
require_once __DIR__ . '/DB.class.php';

class AnswerDB extends DB {

    // gets all answers for a question by its id
    // returns array of Answer objects
    function getAnswersByQuestionId($id) {

        $query = "SELECT * FROM answers WHERE question_id = :id";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":id" => $id
            ]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Answer");
            $data = $stmt->fetchAll();

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
        }

        return $data;
    }

    // inserts an answer
    // returns last insert id if successful
    function insertAnswer($questionId, $answer) {

        $query = "INSERT INTO answers (question_id, answer) VALUES (:questionId, :answer)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":questionId" => $questionId,
                ":answer" => $answer
            ]);

            return $this->db->lastInsertId(); // returns id if successful

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return null;
        }
    }

}