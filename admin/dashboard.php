<?php
session_start();
include '../database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get total events
$event_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM events");
$event_data = mysqli_fetch_assoc($event_query);
$total_events = $event_data['total'];

// Get total students
$student_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'");
$student_data = mysqli_fetch_assoc($student_query);
$total_students = $student_data['total'];

// Get total registrations
$registration_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM registrations");
$registration_data = mysqli_fetch_assoc($registration_query);
$total_registrations = $registration_data['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | CampusConnect</title>

    <link rel="stylesheet" href="../style.css">

    <style>

        body {
            background: #f6f7fb;
        }

        .dashboard {
            padding: 50px 7%;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .dashboard-header h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .dashboard-header p {
            color: #6b7280;
        }

        .logout-btn {
            background: #fee2e2;
            color: #b91c1c;
            padding: 11px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: 600;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        .stat-icon {
            font-size: 35px;
            margin-bottom: 12px;
        }

        .stat-card h2 {
            font-size: 32px;
            margin: 5px 0;
        }

        .stat-card p {
            color: #6b7280;
            margin: 0;
        }

        .admin-actions {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        .admin-actions h2 {
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            background: #5b4bdb;
            color: white;
        }

        .action-btn.secondary {
            background: #eeeefb;
            color: #4b3db5;
        }

        @media (max-width: 700px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

        }

    </style>

</head>

<body>

<nav class="navbar">

    <div class="logo">
        Campus<span>Connect</span>
    </div>

    <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="../events.php">Events</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</nav>


<section class="dashboard">

    <div class="dashboard-header">

        <div>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> 👋</h1>
            <p>Manage college events and registrations from here.</p>
        </div>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </div>


    <div class="stats">

        <div class="stat-card">

            <div class="stat-icon">📅</div>

            <h2><?php echo $total_events; ?></h2>

            <p>Total Events</p>

        </div>


        <div class="stat-card">

            <div class="stat-icon">👨‍🎓</div>

            <h2><?php echo $total_students; ?></h2>

            <p>Registered Students</p>

        </div>


        <div class="stat-card">

            <div class="stat-icon">📝</div>

            <h2><?php echo $total_registrations; ?></h2>

            <p>Total Registrations</p>

        </div>

    </div>


    <div class="admin-actions">

        <h2>Quick Actions</h2>

        <div class="action-buttons">

            <a href="add_event.php" class="action-btn">
                ➕ Add New Event
            </a>

            <a href="manage_events.php" class="action-btn secondary">
                📋 Manage Events
            </a>

            <a href="../events.php" class="action-btn secondary">
                👀 View Events
            </a>

        </div>

    </div>

</section>


<footer>

    <h3>CampusConnect</h3>

    <p>
        Cloud-Based College Event Registration and Management System
    </p>

</footer>

</body>

</html>