<?php
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();
$config = require __DIR__ . "/config/config.php";

// rolling 60-minute expiration, resets every time user interacts with page
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
} else if (time() - $_SESSION['LAST_ACTIVITY'] > 3600) {
    session_unset();
    session_destroy();
    header("Location: login.php?expired=1");
    exit;
}

$_SESSION['LAST_ACTIVITY'] = time(); // update timestamp

// redirect users if not logged in
if (empty($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

// redirect non admin users
if (!in_array($_SESSION['email'], $config['admins'])) {
    header("Location: unauthorized.php"); 
    exit;
}

$page = "";
$group = "home";
$path = "";
$title = "Admin";

require_once ($path . "assets/inc/header.php");
require_once ($path . "data/Answer.class.php");
require_once ($path . "data/Answer.DB.class.php");
require_once ($path . "data/Question.class.php");
require_once ($path . "data/Question.DB.class.php");
require_once ($path . "data/Student.class.php");
require_once ($path . "data/Student.DB.class.php");

// connect to db
$answerDB = new AnswerDB();
$questionDB = new QuestionDB();
$studentDB = new StudentDB();

// id values in the db
$TERM_ID = 52;
$SECTION_ID = 4;
$MAJOR_ID = 3;

// get lists of data to filter by
$terms = $answerDB->getAnswerListByQuestionId($TERM_ID);
$sections = $answerDB->getAnswerListByQuestionId($SECTION_ID);
$majors = $answerDB->getAnswerListByQuestionId($MAJOR_ID);
$students = $studentDB->getAllStudentIds();
$personalityQuestions = $questionDB->getQuestionsByQuestionType('personality');
$technicalQuestions = $questionDB->getQuestionsByQuestionType('technical');
$questions = array_merge($personalityQuestions, $technicalQuestions);

?>

        <section class="title-container">
            <h1 id="title">Senior Development</h1>
            <h3 id="subtitle">Administration</h3>
        </section>

        <section class="admin-container">

            <div class="filter-div">

                <span>Filter</span>

                <!-- term filter -->
                <div class="filter">
                    <div class="filter-item">Term</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($terms as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item) ?>">
                                <?= ucfirst(htmlspecialchars($item)) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- section filter -->
                <div class="filter">
                    <div class="filter-item">Section</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($sections as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item) ?>">
                                <?= ucfirst(htmlspecialchars($item)) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- major filter -->
                <div class="filter">
                    <div class="filter-item">Major</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($majors as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item) ?>">
                                <?= ucfirst(htmlspecialchars($item)) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- question filter -->
                <div class="filter">
                    <div class="filter-item">Question</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($questions as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item->getQuestion()) ?>">
                                <?= ucfirst(htmlspecialchars($item->getQuestion())) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- student filter -->
                <div class="filter">
                    <div class="filter-item">Student</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($students as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item) ?>">
                                <?= ucfirst(htmlspecialchars($item)) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- sort filter -->
                <div class="filter">
                    <div class="filter-item">Sort</div>
                    <div class="filter-options">
                        <div class="filter-option" data-value="Term">Term</div>
                        <div class="filter-option" data-value="Section">Section</div>
                        <div class="filter-option" data-value="Major">Major</div>
                        <div class="filter-option" data-value="Question">Question</div>
                        <div class="filter-option" data-value="Student">Student</div>
                    </div>
                </div>

                <button id="apply-filters">Apply</button>
                <button id="clear-filters">Reset</button>

            </div>

            <div class="table-div">
                
            </div>

        </section>

        <link rel="stylesheet" href="./assets/css/admin.css">
        <script type="module" src="./assets/js/admin.js"></script>