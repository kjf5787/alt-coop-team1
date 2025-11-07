<?php
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

    // get filter lists from db
    $answerDB = new AnswerDB();
    $questionDB = new QuestionDB();
    $studentDB = new StudentDB();

    $terms = $answerDB->getAnswerListByQuestionId(52);
    $sections = $answerDB->getAnswerListByQuestionId(4);
    $majors = $answerDB->getAnswerListByQuestionId(3);
    $questions = $questionDB->getQuestions();
    $students = $studentDB->getAllStudentIds();

?>

        <section class="title-container">
            <h1 id="title">Senior Development</h1>
            <h3 id="subtitle">Administration</h3>
        </section>

        <section class="admin-container">

            <div class="filter-div">

                <span>Filter</span>

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

                <div class="filter">
                    <div class="filter-item">Question</div>
                    <div class="filter-options">
                        <input type="text" class="filter-search" placeholder="Type to filter...">
                        <?php foreach ($questions as $item): ?>
                            <div class="filter-option" data-value="<?= htmlspecialchars($item) ?>">
                                <?= ucfirst(htmlspecialchars($item)) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

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

                <button id="apply-filters">Apply</button>
                <button id="clear-filters">Reset</button>

            </div>

            <div class="table-div">
                
            </div>

        </section>

        <link rel="stylesheet" href="./assets/css/admin.css">
        <script type="module" src="./assets/js/admin.js"></script>