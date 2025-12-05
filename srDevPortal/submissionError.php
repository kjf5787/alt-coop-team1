<?php
    $page = "";
    $group = "home";
    $path = "";
    $title = "error alert";
    require_once ($path . "assets/inc/header.php");
?>
<section class="error-container">
    <div class="e-box">
        <div class="error-box">
            <p>ERROR: Response not recorded.</p>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="index.php" class="back-btn">Back to Form</a>
        </div>
    </div>
</section>
</body>
</html>
