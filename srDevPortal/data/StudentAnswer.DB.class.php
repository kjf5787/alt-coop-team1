<?php

require_once __DIR__ . '/StudentAnswer.class.php';
require_once __DIR__ . '/DB.class.php';

class StudentAnswerDB extends DB {

    // gets a specific student's answers
    // returns an array of answers
    function getStudentAnswers($studentId){
        $query = "SELECT * FROM student_answers WHERE student_id = :studentId ORDER BY question_id ASC";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":studentId" => $studentId
            ]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "StudentAnswer");
            $data = $stmt->fetchAll();

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
        }

        return $data;
    }

    // inserts a student's answer
    // returns last insert id if successful
    function insertStudentAnswer($studentId, $questionId, $answer) {

        $query = "INSERT INTO student_answers (student_id, question_id, answer) VALUES (:studentId, :questionId, :answer)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":studentId" => $studentId,
                ":questionId" => $questionId,
                ":answer" => $answer
            ]);

            return $this->db->lastInsertId(); // returns id if successful

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return false;
        }
    }

    // updates a student's answer by student id and question id
    // returns true if updated successfully, false if not
    function updateStudentAnswer($studentId, $questionId, $answer) {

        $query = "UPDATE student_answers SET answer = :answer WHERE student_id = :studentId AND question_id = :questionId";
    
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":answer" => $answer,
                ":studentId" => $studentId,
                ":questionId" => $questionId
            ]);
    
            return $stmt->rowCount() > 0; // true if updated
    
        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return false;
        }
    }
}