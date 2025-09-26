<?php
    $page = "";
    $group = "home";
    $path = "";
    $title = "Senior Development";
    include ($path . "assets/inc/header.php");
    include ($path . "data/Answer.class.php");
    include ($path . "data/Answers.DB.class.php");
    include ($path . "data/DB.class.php");
    include ($path . "data/Question.class.php");
    include ($path . "data/Question.DB.class.php");
    include ($path . "data/Student.class.php");
    include ($path . "data/Student.DB.class.php");
    include ($path . "data/StudentAnswer.class.php");
    include ($path . "data/StudentAnswer.DB.class.php");
?>

        <section class="title-container">
            <h1 id="title">Senior Development</h1>
            <h3 id="subtitle">Self-Assessment</h3>
        </section>
        <form class="question-container" action="">
            <div class="q-box">
                <p class="q-section-title">
                    Personal Information
                </p>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Personality Assessment
                </p>
            </div>
            <div class="q-box">
                <p class="q-section-title">
                    Technical Assessment
                </p>
            </div>
        </form>
    </body>
</html>