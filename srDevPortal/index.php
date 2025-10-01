<?php
    $page = "";
    $group = "home";
    $path = "";
    $title = "Senior Development";
    require_once ($path . "assets/inc/header.php");
    require_once ($path . "data/Answer.class.php");
    require_once ($path . "data/Answer.DB.class.php");
    require_once ($path . "data/DB.class.php");
    require_once ($path . "data/Question.class.php");
    require_once ($path . "data/Question.DB.class.php");
    require_once ($path . "data/Student.class.php");
    require_once ($path . "data/Student.DB.class.php");
    require_once ($path . "data/StudentAnswer.class.php");
    require_once ($path . "data/StudentAnswer.DB.class.php");

    // connect to db and pull questions and answers
    $questionDB = new QuestionDB();
    $answerDB = new AnswerDB();

    $informationalQuestions = $questionDB->getQuestionsByQuestionType('informational');
    $personalityQuestions = $questionDB->getQuestionsByQuestionType('personality');
    $technicalQuestions = $questionDB->getQuestionsByQuestionType('technical');
?>

        <section class="title-container">
            <h1 id="title">Senior Development</h1>
            <h3 id="subtitle">Self-Assessment</h3>
        </section>
        <form class="question-container" action="process_form.php" method="post">
            <div class="q-box">
                <p class="q-section-title">
                    Personal Information
                </p>
                <!-- populate questions and answers from db -->
                <?php foreach ($informationalQuestions as $q): ?>
                    <label for="question_<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>

                    <?php if (strtolower(trim($q->getInputType())) === 'select'): ?>
                        <?php
                        $answers = $answerDB->getAnswersByQuestionId($q->getId());
                        ?>
                        <select name="<?= $q->getName() ?>" id="question_<?= $q->getId() ?>">
                            <option value="">Select...</option>
                            <?php foreach ($answers as $a): ?>
                                <option value="<?= htmlspecialchars($a->getId()) ?>"><?= htmlspecialchars($a->getAnswer()) ?></option>
                            <?php endforeach; ?>
                        </select>

                    <?php else: ?>
                        <input type="text" name="<?= $q->getName() ?>" id="question_<?= $q->getId() ?>" />
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Personality Assessment
                </p>

                <!-- populate questions from db -->
                <?php foreach ($personalityQuestions as $q): ?>
                    <label for="question_<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>

                    <input type="range" id="question_<?= $q->getId() ?>" name="question_<?= $q->getId() ?>" min="1" max="5" step="1" value="3">
                <?php endforeach; ?>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Technical Assessment
                </p>

                <!-- populate questions from db -->
                <?php foreach ($technicalQuestions as $q): ?>
                    <label for="question_<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>

                    <input type="range" id="question_<?= $q->getId() ?>" name="question_<?= $q->getId() ?>" min="1" max="5" step="1" value="3">
                <?php endforeach; ?>
            </div>

            <div class="submit-box">
                <button type="submit">Submit</button>
            </div>
        </form>
    </body>
</html>