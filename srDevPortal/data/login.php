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
                <form class="login-form" id="loginForm">
                    <div class="login-box">
                        <input type="email" id="ritEmail" name="ritEmail" placeholder="Your RIT email" required/>
                    </div>

                    <div class="submit-box" id="login-s-box">
                        <button type="button" id="sendOtpBtn">Send OTP</button>
                    </div>

                    <div class="login-box" id="otpBox" style="display:none;">
                        <input type="text" id="otpCode" name="otpCode" placeholder="Enter OTP code"/>
                    </div>

                    <div class="submit-box" id="verify-box" style="display:none;">
                        <button type="button" id="verifyOtpBtn">Verify & Login</button>
                    </div>
                </form>
                <div id="message"></div>
            </div>
        </section>

        <script>
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            const verifyOtpBtn = document.getElementById('verifyOtpBtn');
            const messageDiv = document.getElementById('message');

            sendOtpBtn.addEventListener('click', async () => {
                const email = document.getElementById('ritEmail').value;
                
                if (!email) {
                    messageDiv.textContent = 'Please enter your email';
                    return;
                }

                sendOtpBtn.disabled = true;
                sendOtpBtn.textContent = 'Sending...';

                const response = await fetch('data/send-otp.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email })
                });

                const result = await response.json();

                if (result.success) {
                    messageDiv.textContent = 'OTP sent to your email!';
                    document.getElementById('otpBox').style.display = 'block';
                    document.getElementById('verify-box').style.display = 'block';
                } else {
                    messageDiv.textContent = result.message;
                    sendOtpBtn.textContent = 'Send OTP';
                }
                
                sendOtpBtn.disabled = false;
            });

            verifyOtpBtn.addEventListener('click', async () => {
                const otp = document.getElementById('otpCode').value;
                const email = document.getElementById('ritEmail').value;

                if (!otp) {
                    messageDiv.textContent = 'Please enter OTP';
                    return;
                }

                const response = await fetch('data/verify-otp.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ otp, email })
                });

                const result = await response.json();
 
                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    messageDiv.textContent = result.message;
                }
            });
        </script>
    </body>
</html>