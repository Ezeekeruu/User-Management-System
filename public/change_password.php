<?php

require "../components/auth.php";
require "../components/pdo.php";

require_login();

$id = $_SESSION["user_id"];

if ($_POST) {

    $password = password_hash(

        $_POST["password"],
        PASSWORD_DEFAULT

    );

    $stmt = $pdo->prepare(

        "UPDATE users SET
        password_hash=?
        WHERE id=?"

    );

    $stmt->execute([

        $password,
        $id

    ]);

    echo "Password Updated";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 11px 22px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .success-message {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        #confirm_password {
            width: 100%;
            padding: 12px 14px;
            padding-right: 45px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        #confirm_password:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        #confirm_password.match {
            border-color: #28a745 !important;
            background-color: #f1f9f5 !important;
        }

        #confirm_password.no-match {
            border-color: #e74c3c !important;
            background-color: #fef5f5 !important;
        }

        .btn-primary:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }

        .btn-primary:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-title">🔐 Change Password</div>
            <a href="profile.php" style="color: white; text-decoration: none;">Back to Profile</a>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1 class="card-title">Update Your Password</h1>

            <form method="POST" id="passwordForm">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input 
                        id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="Enter your new password"
                        minlength="6"
                        oninput="checkPasswordMatch()"
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input 
                            id="confirm_password"
                            type="password"
                            placeholder="Confirm your password"
                            minlength="6"
                            oninput="checkPasswordMatch()"
                            style="flex: 1;"
                        >
                        <span id="matchIcon" style="
                            position: absolute;
                            right: 14px;
                            font-size: 20px;
                            display: none;
                            color: #28a745;
                        ">✓</span>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="submitBtn" onclick="return confirmPasswordChange()" disabled style="opacity: 0.6; cursor: not-allowed;">🔐 Change Password</button>
                </div>
            </form>

            <a href="profile.php" class="back-link">← Back to Profile</a>
        </div>
    </div>

    <script>
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPasswordInput = document.getElementById('confirm_password');
            const confirmPassword = confirmPasswordInput.value;
            const matchIcon = document.getElementById('matchIcon');
            const submitBtn = document.getElementById('submitBtn');

            if (confirmPassword === '' || password === '') {
                matchIcon.style.display = 'none';
                confirmPasswordInput.classList.remove('match', 'no-match');
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                return;
            }

            if (password === confirmPassword && password.length >= 6) {
                matchIcon.style.display = 'inline-block';
                matchIcon.style.color = '#28a745';
                matchIcon.textContent = '✓';
                confirmPasswordInput.classList.add('match');
                confirmPasswordInput.classList.remove('no-match');
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                matchIcon.style.display = 'inline-block';
                matchIcon.style.color = '#e74c3c';
                matchIcon.textContent = '✗';
                confirmPasswordInput.classList.add('no-match');
                confirmPasswordInput.classList.remove('match');
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }

        function confirmPasswordChange() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return false;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long!');
                return false;
            }

            return confirm('Are you sure you want to change your password?');
        }
    </script>
</body>
</html>