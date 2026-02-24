<?php

require "../components/auth.php";
require "../components/pdo.php";

require_admin();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_sanitized = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR firstname LIKE ? OR lastname LIKE ? ORDER BY id ASC");
    $search_param = '%' . $search . '%';
    $stmt->execute([$search_param, $search_param, $search_param, $search_param]);
} else {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
}

$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
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
            max-width: 1200px;
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .search-box input {
            flex: 1;
            max-width: 400px;
            padding: 11px 14px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        .search-box button {
            padding: 11px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-box button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .search-clear {
            display: none;
            padding: 11px 16px;
            background: #e0e0e0;
            color: #333;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .search-clear.show {
            display: inline-block;
        }

        .search-clear:hover {
            background: #d0d0d0;
            transform: translateY(-2px);
        }

        .search-results-info {
            margin-bottom: 20px;
            padding: 12px 16px;
            background-color: #f0f1ff;
            border-left: 4px solid #667eea;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-admin {
            background-color: #ffeaa7;
            color: #d63031;
        }

        .role-user {
            background-color: #dfe6e9;
            color: #2d3436;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit,
        .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #74b9ff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0984e3;
            transform: translateY(-1px);
        }

        .btn-delete {
            background-color: #ff7675;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d63031;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #999;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                flex-direction: column;
            }

            .search-box input {
                max-width: 100%;
            }

            .search-box button,
            .search-clear {
                width: 100%;
            }

            th, td {
                padding: 10px;
                font-size: 12px;
            }

            .actions {
                flex-direction: column;
                gap: 5px;
            }

            .btn-edit, .btn-delete {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-title">👥 User Management</div>
            <div class="header-nav">
                <span style="padding: 8px 16px; opacity: 0.9;">Welcome, <?= htmlspecialchars($_SESSION['firstname']) ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Manage Users</h1>
            <a href="admin_users_create.php" class="btn-primary">+ Add New User</a>
        </div>

        <form method="GET" class="search-form">
            <div class="search-box">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by username, email, or name..." 
                    value="<?= $search_sanitized ?>"
                >
                <button type="submit">🔍 Search</button>
                <?php if (!empty($search)): ?>
                    <a href="admin_users.php" class="search-clear show">✕ Clear</a>
                <?php else: ?>
                    <a href="admin_users.php" class="search-clear">✕ Clear</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (!empty($search)): ?>
            <div class="search-results-info">
                Search results for: <strong><?= $search_sanitized ?></strong> (<?= count($users) ?> result<?= count($users) !== 1 ? 's' : '' ?> found)
            </div>
        <?php endif; ?>

        <?php if (count($users) > 0): ?>
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number"><?= count($users) ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= count(array_filter($users, fn($u) => $u['role'] == 'admin')) ?></div>
                    <div class="stat-label">Admins</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= count(array_filter($users, fn($u) => $u['role'] == 'user')) ?></div>
                    <div class="stat-label">Regular Users</div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u["id"]) ?></td>
                            <td><strong><?= htmlspecialchars($u["username"]) ?></strong></td>
                            <td><?= htmlspecialchars($u["email"]) ?></td>
                            <td><?= htmlspecialchars($u["firstname"] . " " . $u["lastname"]) ?></td>
                            <td>
                                <span class="role-badge role-<?= $u["role"] === 'admin' ? 'admin' : 'user' ?>">
                                    <?= $u["role"] === 'admin' ? 'Admin' : 'User' ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="admin_users_edit.php?id=<?= $u["id"] ?>" class="btn-edit">Edit</a>
                                    <a href="admin_users_delete.php?id=<?= $u["id"] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <p>No users found. <a href="admin_users_create.php" class="btn-primary">Create the first user</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>