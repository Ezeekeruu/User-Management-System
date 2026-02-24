<?php
require "../components/auth.php";
require "../components/pdo.php";
require_admin();

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: admin_users.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_POST) {
    $stmt = $pdo->prepare("UPDATE users SET firstname=?, lastname=?, gender=?, nationality=?, contact_number=?, role=? WHERE id=?");
    $stmt->execute([$_POST["firstname"], $_POST["lastname"], $_POST["gender"], $_POST["nationality"], $_POST["contact_number"], $_POST["role"], $id]);
    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin</title>
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

        .form-group input,
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

        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .user-info p {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .user-info strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-title">✏️ Edit User</div>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1 class="card-title">Modify User Details</h1>

            <div class="user-info">
                <p><strong>Username:</strong> <?= htmlspecialchars($user["username"]) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
            </div>

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
                        <option value="male" <?= $user["gender"] == "male" ? "selected" : "" ?>>Male</option>
                        <option value="female" <?= $user["gender"] == "female" ? "selected" : "" ?>>Female</option>
                        <option value="other" <?= $user["gender"] == "other" ? "selected" : "" ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nationality">Nationality</label>
                    <input 
                        id="nationality"
                        type="text"
                        name="nationality"
                        value="<?= htmlspecialchars($user["nationality"] ?? '') ?>"
                        placeholder="Enter nationality"
                    >
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input 
                        id="contact_number"
                        type="tel"
                        name="contact_number"
                        value="<?= htmlspecialchars($user["contact_number"] ?? '') ?>"
                        placeholder="Enter contact number"
                    >
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="user" <?= $user["role"] == "user" ? "selected" : "" ?>>User</option>
                        <option value="admin" <?= $user["role"] == "admin" ? "selected" : "" ?>>Admin</option>
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" onclick="return confirmEdit()">💾 Save Changes</button>
                    <a href="admin_users.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmEdit() {
            return confirm('Are you sure you want to save these changes?');
        }
    </script>
</body>
</html>