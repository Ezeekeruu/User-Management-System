<?php

require "../components/pdo.php";
session_start();

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST["login"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($login) || empty($password)) {
        $error = "Username/email and password are required";
    } else {
        try {
            $stmt = $pdo->prepare(
                "SELECT id, username, email, password_hash, role, firstname, lastname 
                 FROM users 
                 WHERE username = ? OR email = ?"
            );
            $stmt->execute([$login, $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password_hash"])) {
                // Set session variables
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["lastname"] = $user["lastname"];

                // Redirect based on role
                if ($user["role"] == "admin") {
                    header("Location: admin_users.php", true, 302);
                } else {
                    header("Location: profile.php", true, 302);
                }
                exit;

            } else {
                $error = "Invalid username/email or password";
            }
        } catch (Exception $e) {
            $error = "An error occurred. Please try again.";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 380px;
            padding: 35px 30px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .login-header p {
            font-size: 12px;
            color: #999;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        .error-message {
            background-color: #fee;
            border-left: 4px solid #e74c3c;
            color: #c0392b;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 14px;
            font-size: 13px;
            display: <?= $error ? 'block' : 'none' ?>;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .test-credentials {
            margin-top: 18px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .test-header {
            font-size: 11px;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .test-account {
            margin-bottom: 10px;
            padding: 8px 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .test-label {
            font-size: 11px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .test-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .test-field {
            font-size: 11px;
            color: #555;
            font-family: 'Courier New', monospace;
        }

        .test-field strong {
            color: #333;
            font-family: inherit;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>User Management System</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="login">Username or Email</label>
                <input 
                    id="login"
                    type="text" 
                    name="login" 
                    required 
                    placeholder="Enter your username or email"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    id="password"
                    type="password" 
                    name="password" 
                    required 
                    placeholder="Enter your password"
                >
            </div>

            <button type="submit" class="login-button">Sign In</button>
        </form>

        <!-- Test Credentials Section -->
        <div class="test-credentials">
            <div class="test-header">📋 Test Accounts</div>
            <div class="test-account">
                <div class="test-label">Admin Account</div>
                <div class="test-info">
                    <span class="test-field"><strong>Username:</strong> eze</span>
                    <span class="test-field"><strong>Password:</strong> password</span>
                </div>
            </div>
            <div class="test-account">
                <div class="test-label">User Account</div>
                <div class="test-info">
                    <span class="test-field"><strong>Username:</strong> cha</span>
                    <span class="test-field"><strong>Password:</strong> password</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>