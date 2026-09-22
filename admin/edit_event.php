<?php

session_start();
include '../database.php';


// Check admin login
if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();

}


// Get event ID
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Check valid event ID
if ($event_id <= 0) {

    die("Invalid event ID.");

}


// Get existing event
$query = "SELECT * FROM events WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $event_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$event = mysqli_fetch_assoc($result);


// Check event exists
if (!$event) {

    die("Event not found.");

}


$message = "";
$success = false;


// Update event
if (isset($_POST['update_event'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = trim($_POST['venue']);
    $capacity = intval($_POST['capacity']);


    if (
        $title == "" ||
        $description == "" ||
        $event_date == "" ||
        $event_time == "" ||
        $venue == "" ||
        $capacity <= 0
    ) {

        $message = "Please fill in all fields correctly.";

    } else {

        $update_query = "
            UPDATE events
            SET
                title = ?,
                description = ?,
                event_date = ?,
                event_time = ?,
                venue = ?,
                capacity = ?
            WHERE id = ?
        ";


        $update_stmt = mysqli_prepare(
            $conn,
            $update_query
        );


        mysqli_stmt_bind_param(
            $update_stmt,
            "sssssii",
            $title,
            $description,
            $event_date,
            $event_time,
            $venue,
            $capacity,
            $event_id
        );


        if (mysqli_stmt_execute($update_stmt)) {

            $message = "Event updated successfully! 🎉";

            $success = true;


            // Get updated event data
            $refresh_query = "SELECT * FROM events WHERE id = ?";

            $refresh_stmt = mysqli_prepare(
                $conn,
                $refresh_query
            );

            mysqli_stmt_bind_param(
                $refresh_stmt,
                "i",
                $event_id
            );

            mysqli_stmt_execute($refresh_stmt);

            $refresh_result =
                mysqli_stmt_get_result($refresh_stmt);

            $event =
                mysqli_fetch_assoc($refresh_result);

        } else {

            $message =
                "Unable to update the event. Please try again.";

        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Event | CampusConnect</title>

    <link rel="stylesheet" href="../style.css">


    <style>

        body {
            background: #f6f7fb;
        }


        .edit-page {

            min-height: 75vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 60px 20px;

        }


        .edit-box {

            width: 650px;

            max-width: 100%;

            background: white;

            padding: 40px;

            border-radius: 22px;

            box-shadow:
                0 15px 45px rgba(0,0,0,0.10);

        }


        .edit-header {

            text-align: center;

            margin-bottom: 30px;

        }


        .edit-header .icon {

            font-size: 50px;

            margin-bottom: 10px;

        }


        .edit-header h1 {

            margin-bottom: 8px;

        }


        .edit-header p {

            color: #6b7280;

        }


        .form-group {

            margin-bottom: 20px;

        }


        .form-group label {

            display: block;

            font-weight: 600;

            margin-bottom: 8px;

            color: #374151;

        }


        .form-group input,
        .form-group textarea {

            width: 100%;

            padding: 13px;

            border: 1px solid #ddd;

            border-radius: 9px;

            font-size: 15px;

            box-sizing: border-box;

            font-family: inherit;

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


        .form-row {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;

        }


        .edit-submit {

            width: 100%;

            border: none;

            cursor: pointer;

            font-size: 15px;

            margin-top: 5px;

        }


        .message {

            padding: 13px;

            border-radius: 9px;

            margin-bottom: 22px;

            text-align: center;

            font-weight: 600;

        }


        .success {

            background: #dcfce7;

            color: #166534;

        }


        .error {

            background: #fee2e2;

            color: #991b1b;

        }


        .back-link {

            display: block;

            text-align: center;

            margin-top: 20px;

            color: #5b4bdb;

            text-decoration: none;

            font-weight: 600;

        }


        @media (max-width: 600px) {

            .edit-box {

                padding: 25px;

            }


            .form-row {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>


<body>


<!-- NAVBAR -->

<nav class="navbar">

    <div class="logo">

        Campus<span>Connect</span>

    </div>


    <div class="nav-links">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="add_event.php">
            Add Event
        </a>

        <a href="manage_events.php">
            Manage Events
        </a>

        <a href="logout.php"
           class="login-btn">

            Logout

        </a>

    </div>

</nav>


<!-- EDIT EVENT -->

<section class="edit-page">

    <div class="edit-box">


        <div class="edit-header">

            <div class="icon">
                ✏️
            </div>

            <h1>
                Edit Event
            </h1>

            <p>
                Update the event details below.
            </p>

        </div>


        <?php if ($message != ""): ?>

            <div class="message
                <?php echo $success ? 'success' : 'error'; ?>">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="form-group">

                <label>
                    Event Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="<?php
                        echo htmlspecialchars(
                            $event['title']
                        );
                    ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Event Description
                </label>

                <textarea
                    name="description"
                    required
                ><?php
                    echo htmlspecialchars(
                        $event['description']
                    );
                ?></textarea>

            </div>


            <div class="form-row">


                <div class="form-group">

                    <label>
                        Event Date
                    </label>

                    <input
                        type="date"
                        name="event_date"
                        value="<?php
                            echo htmlspecialchars(
                                $event['event_date']
                            );
                        ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Event Time
                    </label>

                    <input
                        type="time"
                        name="event_time"
                        value="<?php
                            echo htmlspecialchars(
                                $event['event_time']
                            );
                        ?>"
                        required
                    >

                </div>


            </div>


            <div class="form-row">


                <div class="form-group">

                    <label>
                        Venue
                    </label>

                    <input
                        type="text"
                        name="venue"
                        value="<?php
                            echo htmlspecialchars(
                                $event['venue']
                            );
                        ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Capacity
                    </label>

                    <input
                        type="number"
                        name="capacity"
                        min="1"
                        value="<?php
                            echo htmlspecialchars(
                                $event['capacity']
                            );
                        ?>"
                        required
                    >

                </div>


            </div>


            <button
                type="submit"
                name="update_event"
                class="primary-btn edit-submit"
            >

                Save Changes →

            </button>


        </form>


        <a href="manage_events.php"
           class="back-link">

            ← Back to Manage Events

        </a>


    </div>

</section>


<!-- FOOTER -->

<footer>

    <h3>
        CampusConnect
    </h3>


    <p>
        Cloud-Based College Event Registration and Management System
    </p>


    <br>


    <p>
        © 2026 CampusConnect. College Project.
    </p>

</footer>


</body>

</html>