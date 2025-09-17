<?php

require_once('./Answer.class.php');
require_once('./DB.class.php');

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
            echo $pe->getMessage();
        }

        return $data;
    }

}