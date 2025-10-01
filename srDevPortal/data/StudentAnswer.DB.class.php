<?php

require_once __DIR__ . '/StudentAnswer.class.php';
require_once __DIR__ . '/DB.class.php';

class StudentAnswerDB extends DB {

    // gets all student answers ordered by student id then question id
    // returns an array of answers
    function getAllStudentAnswers() {
        $query = "SELECT * FROM student_answers ORDER BY student_id ASC, question_id ASC";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "StudentAnswer");
            $data = $stmt->fetchAll();

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
        }

        return $data;
    }

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

    // gets all answers for a specific question
    // returns an array of answers
    function getAnswersByQuestionId($questionId) {
        $query = "SELECT * FROM student_answers WHERE question_id = :questionId ORDER BY student_id ASC";
        $data = [];

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":questionId" => $questionId
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
            return null;
        }
    }

    // updates a student's answer by student id and question id
    // returns true if updated successfully, false if not
    function updateStudentAnswerByIds($studentId, $questionId, $answer) {

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