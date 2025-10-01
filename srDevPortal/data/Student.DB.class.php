<?php

require_once __DIR__ . '/Student.class.php';
require_once __DIR__ . '/DB.class.php';

class StudentDB extends DB {

    // gets all students from DB
    // returns array of student objects
    function getAllStudents() {

        $query = "SELECT * FROM students";
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

    // gets student by id
    // returns a student object, false if not found
    function getStudentById($id) {

        $query = "SELECT * FROM students WHERE id = :id";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([":id" => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Student");
            return $stmt->fetch(); // returns false if not found

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return null;
        }
    }

    // inserts a student
    // returns last insert id if successful
    function insertStudent($id, $email, $preferredName, $major, $section) {

        $query = "INSERT INTO students (id, email, preferredName, major, section) VALUES (:id, :email, :preferredName, :major, :section)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ":id" => $id,
                ":email" => $email,
                ":preferredName" => $preferredName,
                ":major" => $major,
                ":section" => $section
            ]);

            return $this->db->lastInsertId(); // returns id if successful

        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            return null;
        }
    }

    // updates a student
    function updateStudent() {
        // TODO
    }
}