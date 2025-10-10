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
        <form class="question-container" action="processForm.php" method="post">
            <div class="q-box">
                <p class="q-section-title">
                    Personal Information
                </p>
                <!-- populate questions and answers from db -->
                <?php foreach ($informationalQuestions as $q): ?>
                    <div class="questionAnswerBox">
                        <div class="questions informationalQuestions">
                            <label for="<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>
                        </div>

                        <?php if (strtolower(trim($q->getInputType())) === 'select'): ?>
                            <?php
                            $answers = $answerDB->getAnswersByQuestionId($q->getId());
                            ?>
                            <div class="answers informationalAnswers">
                                <div class="dropdown">
                                    <div class="dropdown-selected">Select...</div>
                                    <div class="dropdown-options">
                                        <?php foreach ($answers as $a): ?>
                                            <div data-value="<?= htmlspecialchars($a->getAnswer()) ?>">
                                                <?= htmlspecialchars($a->getAnswer()) ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- hidden input to store dropdown value -->
                                <input type="hidden" name="<?= $q->getName() ?>" class="dropdown-hidden">
                            </div>

                        <?php else: ?>
                            <div class="answers informationalAnswers">
                                <input type="text" name="<?= $q->getName() ?>" id="<?= $q->getId() ?>" placeholder="Your answer" />
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Personality Assessment
                </p>

                <!-- populate questions from db -->
                <?php foreach ($personalityQuestions as $q): ?>
                    <div class="questionAnswerBox">
                        <div class="questions personalityQuestions">
                            <label for="<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>
                        </div>

                        <div class="answers personalityAnswers rangeSlider">
                            <p>Strongly Disagree</p>
                            <input type="range" id="<?= $q->getId() ?>" name="<?= $q->getId() ?>" min="1" max="5" step="1" value="3" class="inputSlider">
                            <p>Strongly Agree</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Technical Assessment
                </p>

                <!-- populate questions from db -->
                <?php foreach ($technicalQuestions as $q): ?>
                    <div class="questionAnswerBox">
                        <div class="questions technicalQuestions">
                            <label for="<?= $q->getId() ?>"><?= htmlspecialchars($q->getQuestion()) ?></label>
                        </div>

                        <div class="answers technicalAnswers rangeSlider">
                            <p>Not At All</p>
                            <input type="range" id="<?= $q->getId() ?>" name="<?= $q->getId() ?>" min="1" max="5" step="1" value="3" class="inputSlider">
                            <p>Extremely</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="submit-box">
                <input type="submit" value="Submit">
            </div>
        </form>
    </body>

    <script>
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelector('.dropdown-options');
            const hiddenInput = dropdown.parentElement.querySelector('.dropdown-hidden');

            // toggle options
            selected.addEventListener('click', () => {
                options.style.display = options.style.display === 'block' ? 'none' : 'block';
            });

            // select option
            options.querySelectorAll('div').forEach(option => {
                option.addEventListener('click', () => {
                    selected.textContent = option.textContent; // show selected text
                    hiddenInput.value = option.dataset.value; // set hidden input value
                    options.style.display = 'none'; // close dropdown
                });
            });

            // close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    options.style.display = 'none';
                }
            });
        });
    </script>

</html>