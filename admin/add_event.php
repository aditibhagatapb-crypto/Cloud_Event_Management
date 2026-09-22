<?php

session_start();
include '../database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_event'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = $_POST['venue'];
    $capacity = $_POST['capacity'];

    $query = "INSERT INTO events
              (title, description, event_date, event_time, venue, capacity)
              VALUES
              ('$title', '$description', '$event_date', '$event_time', '$venue', '$capacity')";

    if (mysqli_query($conn, $query)) {

        $message = "Event added successfully! 🎉";

    } else {

        $message = "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Event | CampusConnect</title>

    <link rel="stylesheet" href="../style.css">

    <style>

        body {
            background: #f6f7fb;
        }

        .event-page {
            min-height: 80vh;
            padding: 50px 20px;
            display: flex;
            justify-content: center;
        }

        .event-box {
            width: 600px;
            background: white;
            padding: 40px;
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.08);
        }

        .event-box h1 {
            margin-bottom: 8px;
        }

        .event-box > p {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #5b4bdb;
        }

        .add-btn {
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #5b4bdb;
            text-decoration: none;
            font-weight: 600;
        }

    </style>

</head>

<body>

<nav class="navbar">

    <div class="logo">
        Campus<span>Connect</span>
    </div>

    <div class="nav-links">

        <a href="dashboard.php">Dashboard</a>

        <a href="../events.php">Events</a>

        <a href="logout.php" class="logout-btn">Logout</a>

    </div>

</nav>


<section class="event-page">

    <div class="event-box">

        <h1>➕ Add New Event</h1>

        <p>Create a new college event for students.</p>


        <?php if ($message != ""): ?>

            <div class="success">
                <?php echo $message; ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="form-group">

                <label>Event Title</label>

                <input
                    type="text"
                    name="title"
                    placeholder="Example: Annual College Fest"
                    required
                >

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    placeholder="Enter event description"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>Event Date</label>

                <input
                    type="date"
                    name="event_date"
                    required
                >

            </div>


            <div class="form-group">

                <label>Event Time</label>

                <input
                    type="time"
                    name="event_time"
                    required
                >

            </div>


            <div class="form-group">

                <label>Venue</label>

                <input
                    type="text"
                    name="venue"
                    placeholder="Example: College Auditorium"
                    required
                >

            </div>


            <div class="form-group">

                <label>Maximum Capacity</label>

                <input
                    type="number"
                    name="capacity"
                    placeholder="Example: 100"
                    min="1"
                    required
                >

            </div>


            <button
                type="submit"
                name="add_event"
                class="primary-btn add-btn"
            >
                Add Event 🎉
            </button>

        </form>


        <a href="dashboard.php" class="back-link">
            ← Back to Dashboard
        </a>

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