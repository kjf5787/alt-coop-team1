<?php

require_once __DIR__ . '/utils/validator.php';
require_once __DIR__ . '/data/Student.DB.class.php';
require_once __DIR__ . '/data/StudentAnswer.DB.class.php';

$studentDB = new StudentDB();
$studentAnswerDB = new StudentAnswerDB();

$emailDomain = "@rit.edu";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $studentId = $_POST['id'] ?? null;
    $preferredName = $_POST['preferredName'] ?? null;
    $major = $_POST['major'] ?? null;
    $section = $_POST['section'] ?? null;
    $term = $_POST['term'] ?? null;

    // insert student
    if($studentId !== null && $preferredName !== null && $major !== null && $section !== null && $term !== null){
        // validate and sanitize
        $studentId = sanitize($studentId);
        $preferredName = sanitize($preferredName);
        $major = sanitize($major);
        $section = sanitize($section);
        $term = sanitize($term);

        $studentId = validateStr($studentId, 30); // max 30 chars
        $preferredName = validateStr($preferredName, 50); // max 50 chars
        $major = validateStr($major, 10); // max 10 chars
        $section = validateStr($section, 10); // max 10 chars
        $term = validateStr($section, 50); // max 50 chars

        if ($studentId === false || $preferredName === false || $major === false || $section === false || $term === false) {
            // todo more user friendly response
            echo "Error: One or more fields are invalid.";
            exit;
        }
        
        // send to submissionError.php if student already submitted form
        $student = $studentDB->getStudentById($studentId);
        if($student){
            // todo more user friendly response
            echo "Error: Only one submission per student";
            exit;
        }

        // get question answers from form
        $ignoredKeys = ['id', 'preferredName', 'major', 'section', 'term'];
        $studentAnswers = [];
        foreach ($_POST as $key => $value) {
            if (in_array($key, $ignoredKeys)) {
                continue; // skip fields that were already processed
            }

            // validate and sanitize
            $sanitizedValue = sanitize($value);
            $validValue = validateNum($sanitizedValue);
            if ($validValue === false || $validValue === null) {
                // todo more user friendly response
                echo "Error: Invalid answer for question $key";
                exit;
            }

            $studentAnswers[$key] = $validValue;
        }

        // insert student to db
        $email = $studentId . $emailDomain;
        $student = $studentDB->insertStudent($studentId, $email, $preferredName, $major, $section, $term);
        if($student === false){
            // todo more user friendly response
            echo "Error: Could not insert student";
            exit;
        }

        // insert answers to db
        foreach ($studentAnswers as $questionId => $answer) {
            $answer = $studentAnswerDB->insertStudentAnswer($studentId, $questionId, $answer);
            if($answer === false){
                // todo more user friendly response
                echo "Error: Could not insert question $key";
                exit;
            }
        }

        header("Location: submissionSuccess.php");
        exit;

    }

}