<?php
    $page = "";
    $group = "home";
    $path = "";
    $title = "Login";
    require_once ($path . "assets/inc/header.php");
?>

        <section class="login-container">
            <div class="l-box">
                <h1>Login</h1>
                <form class="login-form" action="index.php" method="post">
                    <div class="login-box">
                        <input type="text" id="ritEmail" name="ritEmail" placeholder="Your RIT email"/>
                    </div>

                    <div class="submit-box" id="login-s-box">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </section>

    </body>
</html>