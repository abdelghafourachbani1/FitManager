<?php

    require_once "conect.php";

    // fetch courses
    $stmt = $pdo->query("SELECT *FROM courses ORDER BY id DESC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //fetch equipements
    $stmt = $pdo->query("SELECT * FROM equipements ORDER BY id DESC");
    $equipements = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management Platform</title>
    <style>
        /* Pure Native CSS - Beautiful Minimalist Gym Management Platform */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Colors - Dark Theme with Violet Accents */
            --bg-primary: #0a0a0a;
            --bg-secondary: #131313;
            --bg-tertiary: #1f1f1f;
            --bg-hover: #2a2a2a;

            --text-primary: #fafafa;
            --text-secondary: #b4b4b4;
            --text-tertiary: #7a7a7a;

            --accent-violet: #7c3aed;
            --accent-violet-light: #a78bfa;
            --accent-violet-dark: #6d28d9;

            --border-color: #2a2a2a;
            --success: #06b6d4;
            --warning: #f97316;
            --danger: #ef4444;

            /* Typography */
            --font-display: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            --font-body: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        html,
        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-violet);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-violet-light);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-display);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 3.5rem;
        }

        h2 {
            font-size: 2.5rem;
        }

        h3 {
            font-size: 1.75rem;
        }

        h4 {
            font-size: 1.25rem;
        }

        p {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        a {
            color: var(--accent-violet);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--accent-violet-light);
        }

        body {
            display: grid;
            grid-template-columns: 250px 1fr;
            grid-template-rows: auto 1fr;
            min-height: 100vh;
        }

        nav {
            grid-column: 1;
            grid-row: 1 / 3;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            padding: 2rem 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        nav.auth-nav {
            display: none;
        }

        header {
            grid-column: 2;
            grid-row: 1;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header.hidden {
            display: none;
        }

        main {
            grid-column: 2;
            grid-row: 2;
            padding: 3rem 2rem;
            overflow-y: auto;
            background: var(--bg-primary);
        }

        main.auth-main {
            grid-column: 1 / -1;
            grid-row: 1 / -1;
            padding: 0;
        }

        nav ul {
            list-style: none;
        }

        nav a {
            display: block;
            padding: 1rem 1.5rem;
            color: var(--text-secondary);
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            cursor: pointer;
        }

        nav a:hover {
            color: var(--accent-violet);
            background: var(--bg-tertiary);
            border-left-color: var(--accent-violet);
        }

        nav a.active {
            color: var(--accent-violet);
            background: rgba(124, 58, 237, 0.1);
            border-left-color: var(--accent-violet);
            font-weight: 600;
        }

        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: var(--accent-violet);
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.1);
        }

        .card-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: 1px solid transparent;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--accent-violet);
            color: white;
        }

        .btn-primary:hover {
            background: var(--accent-violet-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.3);
        }

        .btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
        }

        .btn-outline {
            background: transparent;
            color: var(--accent-violet);
            border-color: var(--accent-violet);
        }

        .btn-outline:hover {
            background: rgba(124, 58, 237, 0.1);
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            opacity: 0.9;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-secondary);
        }

        thead {
            background: var(--bg-tertiary);
            border-bottom: 2px solid var(--border-color);
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover {
            background: var(--bg-tertiary);
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(6, 182, 212, 0.15);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(249, 115, 22, 0.15);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .flex {
            display: flex;
            gap: 1rem;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flex-col {
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent-violet);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-violet);
        }

        .stat-label {
            color: var(--text-tertiary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--accent-violet);
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .section-title h2 {
            margin: 0;
            font-size: 2rem;
        }

        .tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .tab-btn {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            color: var(--text-tertiary);
            font-weight: 600;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            color: var(--text-primary);
        }

        .tab-btn.active {
            color: var(--accent-violet);
            border-bottom-color: var(--accent-violet);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Landing Page */
        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            gap: 2rem;
        }

        .hero h1 {
            font-size: 4rem;
            background: linear-gradient(135deg, var(--accent-violet), var(--accent-violet-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 600px;
            color: var(--text-secondary);
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        /* Auth Pages */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .auth-form {
            width: 100%;
            max-width: 400px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 3rem;
        }

        .auth-form h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--accent-violet);
        }

        .auth-form .form-group {
            margin-bottom: 1.5rem;
        }

        .auth-form .btn {
            width: 100%;
            margin-top: 1rem;
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-tertiary);
        }

        .auth-link a {
            color: var(--accent-violet);
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
            }

            nav {
                grid-column: 1;
                grid-row: 1;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                display: flex;
                overflow-x: auto;
                padding: 0;
            }

            nav ul {
                display: flex;
                width: 100%;
            }

            nav a {
                padding: 1rem;
                border-left: none;
                border-bottom: 3px solid transparent;
                white-space: nowrap;
            }

            nav a:hover,
            nav a.active {
                border-left: none;
                border-bottom-color: var(--accent-violet);
            }

            header {
                grid-column: 1;
                grid-row: 2;
                flex-direction: column;
            }

            main {
                grid-column: 1;
                grid-row: 3;
                padding: 2rem 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 1.5rem;
            }

            th,
            td {
                padding: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav id="nav">
        <ul>
            <li><a class="nav-link" onclick="showPage('home')">Home</a></li>
            <li><a class="nav-link" onclick="showPage('dashboard')">Dashboard</a></li>
            <li><a class="nav-link" onclick="showPage('courses')">Courses</a></li>
            <li><a class="nav-link" onclick="showPage('equipment')">Equipment</a></li>
            <li><a class="nav-link" onclick="showPage('associations')">Associations</a></li>
            <li style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <a class="nav-link" onclick="showPage('login')">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="header">
        <h4 style="margin: 0;">Gym Management</h4>
        <span style="color: var(--text-tertiary);" id="header-user">Admin</span>
    </header>

    <!-- Main Content -->
    <main id="main">
        <!-- Home Page -->
        <div id="home" class="page active">
            <div class="hero">
                <h1>GymFlow</h1>
                <p>Professional Gym Management Platform</p>
                <p style="font-size: 1rem; color: var(--text-tertiary);">Manage your courses, equipment, and members
                    with ease</p>
                <div class="hero-buttons">
                    <button class="btn btn-primary" onclick="showPage('dashboard')">Go to Dashboard</button>
                    <button class="btn btn-outline" onclick="showPage('login')">Sign In</button>
                </div>
            </div>
        </div>

        <!-- Login Page -->
        <div id="login" class="page">
            <div class="auth-container">
                <form class="auth-form" onsubmit="handleLogin(event)">
                    <h2>Sign In</h2>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign In</button>
                    <div class="auth-link">
                        Don't have an account? <a onclick="showPage('register')">Register</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Register Page -->
        <div id="register" class="page">
            <div class="auth-container">
                <form class="auth-form" onsubmit="handleRegister(event)">
                    <h2>Create Account</h2>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                    <div class="auth-link">
                        Already have an account? <a onclick="showPage('login')">Sign In</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dashboard Page -->
        <div id="dashboard" class="page">
            <div class="section-title">
                <h2>Dashboard</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Active Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">48</div>
                    <div class="stat-label">Total Equipment</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">156</div>
                    <div class="stat-label">Total Members</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">92%</div>
                    <div class="stat-label">Equipment Health</div>
                </div>
            </div>

            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Courses</h3>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Participants</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($course['course_nom']) ?></td>
                                        <td><?= htmlspecialchars($course['categorie']) ?></td>
                                        <td><?= htmlspecialchars($course['date_cours']) ?></td>
                                        <td><?= htmlspecialchars($course['heure_cours']) ?></td>
                                        <td><?= htmlspecialchars($course['duree']) ?></td>
                                        <td><?= htmlspecialchars($course['max_participant']) ?></td>
                                        <td>
                                            <a href="?edit=<?= $course['id'] ?>" class="btn btn-secondary btn-small">Edit</a>
                                            <a href="?delete=<?= $course['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Equipment Status</h3>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dumbbells</td>
                                    <td>120</td>
                                    <td><span class="badge badge-success">Good</span></td>
                                </tr>
                                <tr>
                                    <td>Treadmills</td>
                                    <td>8</td>
                                    <td><span class="badge badge-warning">Medium</span></td>
                                </tr>
                                <tr>
                                    <td>Barbells</td>
                                    <td>24</td>
                                    <td><span class="badge badge-danger">To Replace</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses Page -->
        <div id="courses" class="page">
            <div class="section-title">
                <h2>Courses Management</h2>
                <button class="btn btn-primary" onclick="openModal('courseModal')">+ Add Course</button>
            </div>

            <div class="card">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Max Participants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CrossFit Basics</td>
                                <td>Strength</td>
                                <td>2024-01-15</td>
                                <td>06:00 AM</td>
                                <td>60 mins</td>
                                <td>25</td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('courseModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Yoga Flow</td>
                                <td>Flexibility</td>
                                <td>2024-01-16</td>
                                <td>07:00 AM</td>
                                <td>90 mins</td>
                                <td>20</td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('courseModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Strength Training</td>
                                <td>Strength</td>
                                <td>2024-01-17</td>
                                <td>05:30 AM</td>
                                <td>75 mins</td>
                                <td>30</td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('courseModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Equipment Page -->
        <div id="equipment" class="page">
            <div class="section-title">
                <h2>Equipment Management</h2>
                <button class="btn btn-primary" onclick="openModal('equipmentModal')">+ Add Equipment</button>
            </div>

            <div class="card">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Equipment Name</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dumbbells Set</td>
                                <td>Strength</td>
                                <td>120</td>
                                <td><span class="badge badge-success">Good</span></td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('equipmentModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Treadmills</td>
                                <td>Cardio</td>
                                <td>8</td>
                                <td><span class="badge badge-warning">Medium</span></td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('equipmentModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Barbells</td>
                                <td>Strength</td>
                                <td>24</td>
                                <td><span class="badge badge-danger">To Replace</span></td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('equipmentModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Yoga Mats</td>
                                <td>Flexibility</td>
                                <td>50</td>
                                <td><span class="badge badge-success">Good</span></td>
                                <td>
                                    <button class="btn btn-secondary btn-small"
                                        onclick="openModal('equipmentModal')">Edit</button>
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Associations Page -->
        <div id="associations" class="page">
            <div class="section-title">
                <h2>Course-Equipment Associations</h2>
            </div>

            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter by Course</h3>
                    </div>
                    <div class="form-group">
                        <label>Select Course</label>
                        <select>
                            <option>-- Select a Course --</option>
                            <option>CrossFit Basics</option>
                            <option>Yoga Flow</option>
                            <option>Strength Training</option>
                        </select>
                    </div>
                    <div style="margin-top: 2rem;">
                        <h4>Associated Equipment:</h4>
                        <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox" checked> Dumbbells Set
                            </label>
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox"> Barbells
                            </label>
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox"> Weight Plates
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter by Equipment</h3>
                    </div>
                    <div class="form-group">
                        <label>Select Equipment</label>
                        <select>
                            <option>-- Select Equipment --</option>
                            <option>Dumbbells Set</option>
                            <option>Treadmills</option>
                            <option>Barbells</option>
                            <option>Yoga Mats</option>
                        </select>
                    </div>
                    <div style="margin-top: 2rem;">
                        <h4>Used in Courses:</h4>
                        <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox" checked> CrossFit Basics
                            </label>
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox" checked> Strength Training
                            </label>
                            <label style="display: flex; gap: 0.5rem; cursor: pointer; margin: 0;">
                                <input type="checkbox"> Yoga Flow
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Course Modal -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin: 0;">Add/Edit Course</h3>
                <button class="modal-close" onclick="closeModal('courseModal')">&times;</button>
            </div>
            <form onsubmit="handleCourseSubmit(event)">
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" placeholder="e.g., CrossFit Basics" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select required>
                        <option>-- Select Category --</option>
                        <option>Strength</option>
                        <option>Cardio</option>
                        <option>Flexibility</option>
                        <option>Mixed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" required>
                </div>
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" required>
                </div>
                <div class="form-group">
                    <label>Duration (minutes)</label>
                    <input type="number" placeholder="e.g., 60" required>
                </div>
                <div class="form-group">
                    <label>Max Participants</label>
                    <input type="number" placeholder="e.g., 25" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Course</button>
            </form>
        </div>
    </div>

    <!-- Equipment Modal -->
    <div id="equipmentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin: 0;">Add/Edit Equipment</h3>
                <button class="modal-close" onclick="closeModal('equipmentModal')">&times;</button>
            </div>
            <form onsubmit="handleEquipmentSubmit(event)">
                <div class="form-group">
                    <label>Equipment Name</label>
                    <input type="text" placeholder="e.g., Dumbbells Set" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select required>
                        <option>-- Select Type --</option>
                        <option>Strength</option>
                        <option>Cardio</option>
                        <option>Flexibility</option>
                        <option>Accessories</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" placeholder="e.g., 10" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select required>
                        <option>-- Select Status --</option>
                        <option>Good</option>
                        <option>Medium</option>
                        <option>To Replace</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Equipment</button>
            </form>
        </div>
    </div>

    <script>
        function showPage(pageId) {
            // Hide all pages
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => page.classList.remove('active'));

            // Show selected page
            document.getElementById(pageId).classList.add('active');

            // Update nav active state
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');

            // Show/hide nav and header based on page
            const nav = document.getElementById('nav');
            const header = document.getElementById('header');
            const main = document.getElementById('main');

            if (pageId === 'login' || pageId === 'register' || pageId === 'home') {
                nav.style.display = 'none';
                header.classList.add('hidden');
                main.classList.add('auth-main');
            } else {
                nav.style.display = 'block';
                header.classList.remove('hidden');
                main.classList.remove('auth-main');
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function handleLogin(event) {
            event.preventDefault();
            alert('Login submitted - integrate with your PHP backend\nPOST /api/login');
            showPage('dashboard');
        }

        function handleRegister(event) {
            event.preventDefault();
            alert('Registration submitted - integrate with your PHP backend\nPOST /api/register');
            showPage('login');
        }

        function handleCourseSubmit(event) {
            event.preventDefault();
            alert('Course saved - integrate with your PHP backend\nPOST /api/courses');
            closeModal('courseModal');
        }

        function handleEquipmentSubmit(event) {
            event.preventDefault();
            alert('Equipment saved - integrate with your PHP backend\nPOST /api/equipment');
            closeModal('equipmentModal');
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>