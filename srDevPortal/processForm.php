<?php
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();

require_once __DIR__ . '/utils/validator.php';
require_once __DIR__ . '/data/Student.DB.class.php';
require_once __DIR__ . '/data/StudentAnswer.DB.class.php';

$studentDB = new StudentDB();
$studentAnswerDB = new StudentAnswerDB();

// function to redirect to submissionError.php 
function errorRedirect($msg) {
    header("Location: submissionError.php?msg=" . urlencode($msg));
    exit;
}

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
        $term = validateStr($term, 50); // max 50 chars

        // check if fields are valid, if not send to error page
        if ($studentId === false || $preferredName === false || $major === false || $section === false || $term === false) {
            errorRedirect("1");
        }

        // get question answers from post
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
                errorRedirect("2");
            }

            $studentAnswers[$key] = $validValue;
        }

        //$email = $studentId . $emailDomain;

        // check if student already exists in db
        $existingStudent = $studentDB->getStudentById($studentId);
        if($existingStudent){
            // update student if exists 
            $updated = $studentDB->updateStudent($studentId, $_SESSION['email'], $preferredName, $major, $section, $term);
            if($updated === false){
                errorRedirect("3");
            }
        } else {
            // insert student
            $student = $studentDB->insertStudent($studentId, $_SESSION['email'], $preferredName, $major, $section, $term);
            if($student === false){
                errorRedirect("4");
            }
        }

        // check for any existing answers
        $existingAnswers = $studentAnswerDB->getStudentAnswers($studentId);
        $answerMap = [];
        foreach ($existingAnswers as $ans) {
            $answerMap[$ans->getQuestionId()] = $ans->getAnswer();
        }

        // insert or update answers in db
        foreach ($studentAnswers as $questionId => $answer) {
            if (isset($answerMap[$questionId])) {
                // update answer
                if ($answerMap[$questionId] != $answer) { // if answer is different, update
                    $answer = $studentAnswerDB->updateStudentAnswer($studentId, $questionId, $answer);
                    if ($answer === false) {
                        errorRedirect("5");
                    }
                } // if answer is the same as in db, do nothing
            } else {
                // insert answer
                $answer = $studentAnswerDB->insertStudentAnswer($studentId, $questionId, $answer);
            }
            if ($answer === false) {             
                errorRedirect("5");
            }
        }

        header("Location: submissionSuccess.php");
        exit;

    }

}