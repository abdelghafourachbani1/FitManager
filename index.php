<?php
require "conect.php";

// DELETE COURSE
if (isset($_GET['delete_course_id'])) {
    $id = (int)$_GET['delete_course_id'];
    $pdo->prepare("DELETE FROM courses WHERE id=?")->execute([$id]);
    header("Location: index.php?page=courses");
    exit;
}

// DELETE EQUIPMENT
if (isset($_GET['delete_equip_id'])) {
    $id = (int)$_GET['delete_equip_id'];
    $pdo->prepare("DELETE FROM equipements WHERE id=?")->execute([$id]);
    header("Location: index.php?page=equipments");
    exit;
}

// INSERT COURSE
if (isset($_POST['add_course'])) {
    $pdo->prepare("INSERT INTO courses(course_nom,categorie,date_cours,heure_cours,duree,max_participant) VALUES(?,?,?,?,?,?)")
        ->execute([
            $_POST['course_name'],
            $_POST['course_category'],
            $_POST['course_date'],
            $_POST['course_time'],
            $_POST['course_duration'],
            $_POST['course_max']
        ]);
    header("Location: index.php?page=courses");
    exit;
}

// INSERT EQUIPMENT
if (isset($_POST['add_equipment'])) {
    $pdo->prepare("INSERT INTO equipements(equipement_nom,equipement_type,equipement_quantite,equipement_etat) VALUES(?,?,?,?)")
        ->execute([
            $_POST['equip_name'],
            $_POST['equip_type'],
            $_POST['equip_quantity'],
            $_POST['equip_status']
        ]);
    header("Location: index.php?page=equipments");
    exit;
}

// UPDATE COURSE
if (isset($_POST['update_course'])) {
    $pdo->prepare("UPDATE courses SET course_nom=?,categorie=?,date_cours=?,heure_cours=?,duree=?,max_participant=? WHERE id=?")
        ->execute([
            $_POST['course_name'],
            $_POST['course_category'],
            $_POST['course_date'],
            $_POST['course_time'],
            $_POST['course_duration'],
            $_POST['course_max'],
            $_POST['course_id']
        ]);
    header("Location: index.php?page=courses");
    exit;
}

// UPDATE EQUIPMENT
if (isset($_POST['update_equipment'])) {
    $pdo->prepare("UPDATE equipements SET equipement_nom=?,equipement_type=?,equipement_quantite=?,equipement_etat=? WHERE id=?")
        ->execute([
            $_POST['equip_name'],
            $_POST['equip_type'],
            $_POST['equip_quantity'],
            $_POST['equip_status'],
            $_POST['equip_id']
        ]);
    header("Location: index.php?page=equipments");
    exit;
}

// FETCH DATA
$courses = $pdo->query("SELECT * FROM courses ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
$equipements = $pdo->query("SELECT * FROM equipements ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Total Counters 
$total_courses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$total_equipements = $pdo->query("SELECT COUNT(*) FROM equipements")->fetchColumn();

// Group by Category (Courses) 
$courses_types = $pdo->query("
    SELECT categorie, COUNT(*) as total 
    FROM courses 
    GROUP BY categorie
")->fetchAll(PDO::FETCH_ASSOC);

// Group by Type (Equipements) 
$equipement_types = $pdo->query("
    SELECT equipement_type, COUNT(*) as total 
    FROM equipements 
    GROUP BY equipement_type
")->fetchAll(PDO::FETCH_ASSOC);

// Determine current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gym Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
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
        h3 {
            font-family: var(--font-display);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 2.5rem;
        }

        h2 {
            font-size: 2rem;
        }

        h3 {
            font-size: 1.5rem;
        }

        body {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        nav {
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            padding: 2rem 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
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
            text-decoration: none;
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

        main {
            padding: 3rem 2rem;
            overflow-y: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
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
            background: var(--accent-violet);
            color: white;
        }

        .btn:hover {
            background: var(--accent-violet-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.3);
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn-edit {
            background: var(--success);
            color: white;
        }

        .btn-edit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-del {
            background: var(--danger);
            color: white;
        }

        .btn-del:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-secondary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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

        .modal-content h3 {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--accent-violet);
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        input,
        select {
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
        select:focus {
            outline: none;
            border-color: var(--accent-violet);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .form-buttons button {
            flex: 1;
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
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--accent-violet);
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-violet);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-tertiary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .chart-box {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .chart-box h2 {
            margin-bottom: 1.5rem;
            color: var(--accent-violet);
        }

        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
            }

            nav {
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

            main {
                padding: 2rem 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="?page=dashboard" class="<?= $current_page == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="?page=courses" class="<?= $current_page == 'courses' ? 'active' : '' ?>">Courses</a></li>
            <li><a href="?page=equipments" class="<?= $current_page == 'equipments' ? 'active' : '' ?>">Equipments</a></li>
        </ul>
    </nav>

    <main>
        <?php if ($current_page == 'dashboard'): ?>
            <!-- DASHBOARD PAGE -->
            <div class="page-header">
                <h1>Gym Dashboard</h1>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= $total_courses ?></div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $total_equipements ?></div>
                    <div class="stat-label">Total Equipments</div>
                </div>
            </div>

            <div class="chart-box">
                <h2>Courses by Category</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Course Type</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses_types as $ct): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ct['categorie']) ?></td>
                                    <td><b><?= $ct['total'] ?></b></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="chart-box">
                <h2>Equipment by Type</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Equipment Type</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipement_types as $et): ?>
                                <tr>
                                    <td><?= htmlspecialchars($et['equipement_type']) ?></td>
                                    <td><b><?= $et['total'] ?></b></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php elseif ($current_page == 'courses'): ?>
            <!-- COURSES PAGE -->
            <div class="page-header">
                <h1>Courses</h1>
                <button class="btn" onclick="openAddCourse()">+ Add Course</button>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Max Participants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['course_nom']) ?></td>
                                <td><?= htmlspecialchars($c['categorie']) ?></td>
                                <td><?= $c['date_cours'] ?></td>
                                <td><?= $c['heure_cours'] ?></td>
                                <td><?= $c['duree'] ?></td>
                                <td><?= $c['max_participant'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-small btn-edit"
                                            onclick='openEditCourse(<?= json_encode($c) ?>)'>
                                            Edit
                                        </button>
                                        <a href="?page=courses&delete_course_id=<?= $c['id'] ?>"
                                            class="btn btn-small btn-del"
                                            onclick="return confirm('Are you sure you want to delete this course?')">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($current_page == 'equipments'): ?>
            <!-- EQUIPMENTS PAGE -->
            <div class="page-header">
                <h1>Equipments</h1>
                <button class="btn" onclick="openAddEquip()">+ Add Equipment</button>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipements as $e): ?>
                            <tr>
                                <td><?= $e['id'] ?></td>
                                <td><?= htmlspecialchars($e['equipement_nom']) ?></td>
                                <td><?= htmlspecialchars($e['equipement_type']) ?></td>
                                <td><?= $e['equipement_quantite'] ?></td>
                                <td><?= htmlspecialchars($e['equipement_etat']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-small btn-edit"
                                            onclick='openEditEquip(<?= json_encode($e) ?>)'>
                                            Edit
                                        </button>
                                        <a href="?page=equipments&delete_equip_id=<?= $e['id'] ?>"
                                            class="btn btn-small btn-del"
                                            onclick="return confirm('Are you sure you want to delete this equipment?')">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <!-- ADD COURSE MODAL -->
    <div class="modal" id="addCourseModal">
        <div class="modal-content">
            <h3>Add Course</h3>
            <form method="POST">
                <div>
                    <label>Course Name</label>
                    <input type="text" name="course_name" required>
                </div>
                <div>
                    <label>Category</label>
                    <input type="text" name="course_category" required>
                </div>
                <div>
                    <label>Date</label>
                    <input type="date" name="course_date" required>
                </div>
                <div>
                    <label>Time</label>
                    <input type="time" name="course_time" required>
                </div>
                <div>
                    <label>Duration</label>
                    <input type="time" name="course_duration" required>
                </div>
                <div>
                    <label>Max Participants</label>
                    <input type="number" name="course_max" required>
                </div>
                <div class="form-buttons">
                    <button class="btn" name="add_course">Save</button>
                    <button class="btn btn-del" onclick="closeModals()" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT COURSE MODAL -->
    <div class="modal" id="editCourseModal">
        <div class="modal-content">
            <h3>Edit Course</h3>
            <form method="POST">
                <input type="hidden" id="edit_course_id" name="course_id">
                <div>
                    <label>Course Name</label>
                    <input type="text" id="edit_course_name" name="course_name" required>
                </div>
                <div>
                    <label>Category</label>
                    <input type="text" id="edit_course_category" name="course_category" required>
                </div>
                <div>
                    <label>Date</label>
                    <input type="date" id="edit_course_date" name="course_date" required>
                </div>
                <div>
                    <label>Time</label>
                    <input type="time" id="edit_course_time" name="course_time" required>
                </div>
                <div>
                    <label>Duration</label>
                    <input type="time" id="edit_course_duration" name="course_duration" required>
                </div>
                <div>
                    <label>Max Participants</label>
                    <input type="number" id="edit_course_max" name="course_max" required>
                </div>
                <div class="form-buttons">
                    <button class="btn btn-edit" type="submit" name="update_course">Update</button>
                    <button class="btn btn-del" onclick="closeModals()" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ADD EQUIPMENT MODAL -->
    <div class="modal" id="addEquipModal">
        <div class="modal-content">
            <h3>Add Equipment</h3>
            <form method="POST">
                <div>
                    <label>Name</label>
                    <input type="text" name="equip_name" required>
                </div>
                <div>
                    <label>Type</label>
                    <input type="text" name="equip_type" required>
                </div>
                <div>
                    <label>Quantity</label>
                    <input type="number" name="equip_quantity" required>
                </div>
                <div>
                    <label>Status</label>
                    <select name="equip_status">
                        <option value="Good">Good</option>
                        <option value="Medium">Medium</option>
                        <option value="To Replace">To Replace</option>
                    </select>
                </div>
                <div class="form-buttons">
                    <button class="btn" name="add_equipment">Save</button>
                    <button class="btn btn-del" onclick="closeModals()" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT EQUIPMENT MODAL -->
    <div class="modal" id="editEquipModal">
        <div class="modal-content">
            <h3>Edit Equipment</h3>
            <form method="POST">
                <input type="hidden" id="edit_equip_id" name="equip_id">
                <div>
                    <label>Name</label>
                    <input id="edit_equip_name" name="equip_name" required>
                </div>
                <div>
                    <label>Type</label>
                    <input id="edit_equip_type" name="equip_type" required>
                </div>
                <div>
                    <label>Quantity</label>
                    <input type="number" id="edit_equip_quantity" name="equip_quantity" required>
                </div>
                <div>
                    <label>Status</label>
                    <select id="edit_equip_status" name="equip_status">
                        <option value="Good">Good</option>
                        <option value="Medium">Medium</option>
                        <option value="To Replace">To Replace</option>
                    </select>
                </div>
                <div class="form-buttons">
                    <button class="btn btn-edit" name="update_equipment">Update</button>
                    <button class="btn btn-del" onclick="closeModals()" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // COURSE MODALS 
        function openAddCourse() {
            document.getElementById("addCourseModal").classList.add("active");
        }

        function openEditCourse(course) {
            document.getElementById("edit_course_id").value = course.id;
            document.getElementById("edit_course_name").value = course.course_nom;
            document.getElementById("edit_course_category").value = course.categorie;
            document.getElementById("edit_course_date").value = course.date_cours;
            document.getElementById("edit_course_time").value = course.heure_cours;
            document.getElementById("edit_course_duration").value = course.duree;
            document.getElementById("edit_course_max").value = course.max_participant;
            document.getElementById("editCourseModal").classList.add("active");
        }

        // EQUIPMENT MODALS 
        function openAddEquip() {
            document.getElementById("addEquipModal").classList.add("active");
        }

        function openEditEquip(equip) {
            document.getElementById("edit_equip_id").value = equip.id;
            document.getElementById("edit_equip_name").value = equip.equipement_nom;
            document.getElementById("edit_equip_type").value = equip.equipement_type;
            document.getElementById("edit_equip_quantity").value = equip.equipement_quantite;
            document.getElementById("edit_equip_status").value = equip.equipement_etat;
            document.getElementById("editEquipModal").classList.add("active");
        }

        function closeModals() {
            document.querySelectorAll(".modal").forEach(m => m.classList.remove("active"));
        }

        // Close modal when clicking outside
        document.querySelectorAll(".modal").forEach(modal => {
            modal.addEventListener("click", function(e) {
                if (e.target === modal) {
                    closeModals();
                }
            });
        });
    </script>
</body>

</html>