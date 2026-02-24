<?php

require "../components/auth.php";
require "../components/pdo.php";

require_login();

$id = $_SESSION["user_id"];

$stmt = $pdo->prepare(
    "SELECT * FROM users WHERE id=?"
);

$stmt->execute([$id]);

$user = $stmt->fetch();


if ($_POST) {

    $stmt = $pdo->prepare(

        "UPDATE users SET
        firstname=?,
        lastname=?,
        gender=?,
        nationality=?,
        contact_number=?
        WHERE id=?"

    );

    $stmt->execute([

        $_POST["firstname"],
        $_POST["lastname"],
        $_POST["gender"],
        $_POST["nationality"],
        $_POST["contact_number"],
        $id

    ]);

    // Refresh user data after update
    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE id=?"
    );
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    $success = true;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
            max-width: 1000px;
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

        .header-nav {
            display: flex;
            gap: 15px;
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .header-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .logout-btn {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(232, 57, 70, 0.3);
            cursor: pointer;
            border: none;
        }

        .logout-btn:hover {
            background: rgba(232, 57, 70, 0.5);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-group {
            margin-bottom: 18px;
        }

        .info-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
            word-break: break-word;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .form-group select {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
            background-color: white;
            cursor: pointer;
        }

        .form-group input:focus,
        .form-group select:focus {
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

        .btn-block {
            width: 100%;
        }

        .success-message {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .action-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-decoration: none;
            color: #667eea;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .action-link:hover {
            background-color: #f0f1ff;
            border-left-color: #667eea;
            padding-left: 20px;
        }

        .action-icon {
            margin-right: 10px;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .page-title {
                font-size: 24px;
            }

            .card {
                padding: 20px;
            }

            .footer-actions {
                flex-direction: column;
            }

            .footer-link {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-title">👤 My Profile</div>
            <div class="header-nav">
                <span style="padding: 8px 16px; opacity: 0.9;"><?= htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']) ?></span>
                <a href="change_password.php">🔐 Change Password</a>
                <button onclick="confirmLogout()" class="logout-btn">🚪 Sign Out</button>
            </div>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Profile Settings</h1>

        <?php if (isset($success)): ?>
            <div class="success-message">✓ Your profile has been updated successfully!</div>
        <?php endif; ?>

        <div class="profile-grid">
            <!-- Account Information Card -->
            <div class="card">
                <div class="card-title">📋 Account Information</div>

                <div class="info-group">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?= htmlspecialchars($user["username"]) ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?= htmlspecialchars($user["email"]) ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Account Role</div>
                    <div class="info-value">
                        <span style="
                            display: inline-block;
                            padding: 4px 12px;
                            background-color: #dfe6e9;
                            border-radius: 20px;
                            font-weight: 600;
                            text-transform: uppercase;
                            font-size: 12px;
                        ">
                            <?= $user["role"] === 'admin' ? 'Administrator' : 'User' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Card -->
        <div class="card" style="margin-top: 30px;">
            <div class="card-title">✏️ Edit Profile</div>

            <form method="POST">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input 
                        id="firstname"
                        type="text"
                        name="firstname" 
                        value="<?= htmlspecialchars($user["firstname"]) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input 
                        id="lastname"
                        type="text"
                        name="lastname" 
                        value="<?= htmlspecialchars($user["lastname"]) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" <?= $user["gender"] === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $user["gender"] === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $user["gender"] === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nationality">Nationality</label>
                    <input 
                        id="nationality"
                        type="text"
                        name="nationality" 
                        value="<?= htmlspecialchars($user["nationality"] ?? '') ?>"
                        placeholder="Enter your nationality"
                    >
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input 
                        id="contact_number"
                        type="tel"
                        name="contact_number" 
                        value="<?= htmlspecialchars($user["contact_number"] ?? '') ?>"
                        placeholder="Enter your contact number"
                    >
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" onclick="return confirmProfileEdit()">💾 Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to sign out?')) {
                window.location.href = 'logout.php';
            }
        }

        function confirmProfileEdit() {
            return confirm('Save changes to your profile?');
        }
    </script>
</body>
</html>