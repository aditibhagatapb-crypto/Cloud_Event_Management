<?php

session_start();
include 'database.php';


// Student must be logged in
if (!isset($_SESSION['student_id'])) {

    header("Location: login.php");
    exit();

}


$student_id = $_SESSION['student_id'];


// Get event ID from URL
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;


// If event ID is missing
if ($event_id <= 0) {

    $message = "Invalid event selected.";
    $type = "error";

} else {

    // Get event details
    $event_query = "SELECT * FROM events WHERE id = ?";
    $stmt = mysqli_prepare($conn, $event_query);

    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);

    $event_result = mysqli_stmt_get_result($stmt);
    $event = mysqli_fetch_assoc($event_result);


    // Check if event exists
    if (!$event) {

        $message = "Event not found.";
        $type = "error";

    } else {

        // Check if student already registered
        $check_query = "
            SELECT id
            FROM registrations
            WHERE user_id = ? AND event_id = ?
        ";

        $check_stmt = mysqli_prepare($conn, $check_query);

        mysqli_stmt_bind_param(
            $check_stmt,
            "ii",
            $student_id,
            $event_id
        );

        mysqli_stmt_execute($check_stmt);

        $check_result = mysqli_stmt_get_result($check_stmt);


        if (mysqli_num_rows($check_result) > 0) {

            $message = "You are already registered for this event.";
            $type = "warning";

        } else {

            // Count current registrations
            $count_query = "
                SELECT COUNT(*) AS total
                FROM registrations
                WHERE event_id = ?
            ";

            $count_stmt = mysqli_prepare($conn, $count_query);

            mysqli_stmt_bind_param(
                $count_stmt,
                "i",
                $event_id
            );

            mysqli_stmt_execute($count_stmt);

            $count_result = mysqli_stmt_get_result($count_stmt);

            $count_data = mysqli_fetch_assoc($count_result);

            $current_registrations = $count_data['total'];


            // Check capacity
            if ($current_registrations >= $event['capacity']) {

                $message = "Sorry, this event is already full.";
                $type = "error";

            } else {

                // Register student
                $insert_query = "
                    INSERT INTO registrations (user_id, event_id)
                    VALUES (?, ?)
                ";

                $insert_stmt = mysqli_prepare($conn, $insert_query);

                mysqli_stmt_bind_param(
                    $insert_stmt,
                    "ii",
                    $student_id,
                    $event_id
                );


                if (mysqli_stmt_execute($insert_stmt)) {

                    $message = "Registration successful! 🎉";
                    $type = "success";

                } else {

                    $message = "Something went wrong. Please try again.";
                    $type = "error";

                }

            }

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

    <title>Event Registration | CampusConnect</title>

    <link rel="stylesheet" href="style.css">


    <style>

        body {
            background: #f6f7fb;
        }


        .registration-page {

            min-height: 80vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 60px 20px;

        }


        .registration-box {

            width: 500px;

            background: white;

            padding: 45px;

            border-radius: 22px;

            text-align: center;

            box-shadow: 0 15px 45px rgba(0,0,0,0.10);

        }


        .registration-icon {

            font-size: 65px;

            margin-bottom: 15px;

        }


        .registration-box h1 {

            font-size: 30px;

            margin-bottom: 12px;

        }


        .registration-box p {

            color: #6b7280;

            line-height: 1.6;

        }


        .event-name {

            font-size: 21px;

            font-weight: 700;

            color: #5b4bdb;

            margin: 20px 0;

        }


        .message {

            padding: 18px;

            border-radius: 12px;

            margin: 25px 0;

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


        .warning {

            background: #fef3c7;

            color: #92400e;

        }


        .back-button {

            display: inline-block;

            margin-top: 10px;

            padding: 13px 24px;

            background: #5b4bdb;

            color: white;

            text-decoration: none;

            border-radius: 9px;

            font-weight: 600;

        }


        .back-button:hover {

            opacity: 0.9;

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

        <a href="index.php">
            Home
        </a>

        <a href="events.php">
            Events
        </a>

        <a href="logout.php"
           class="login-btn">

            Logout

        </a>

    </div>

</nav>



<!-- REGISTRATION RESULT -->

<section class="registration-page">

    <div class="registration-box">


        <?php if ($type == "success"): ?>

            <div class="registration-icon">
                🎉
            </div>

            <h1>
                Registration Successful!
            </h1>

            <p>
                You have successfully registered for:
            </p>


        <?php elseif ($type == "warning"): ?>

            <div class="registration-icon">
                ℹ️
            </div>

            <h1>
                Already Registered
            </h1>

            <p>
                You have already registered for:
            </p>


        <?php else: ?>

            <div class="registration-icon">
                ⚠️
            </div>

            <h1>
                Registration Unsuccessful
            </h1>

        <?php endif; ?>


        <?php if (isset($event)): ?>

            <div class="event-name">

                <?php
                echo htmlspecialchars($event['title']);
                ?>

            </div>


            <p>

                📅

                <?php
                echo date(
                    "d M Y",
                    strtotime($event['event_date'])
                );
                ?>

                <br>

                🕐

                <?php
                echo date(
                    "h:i A",
                    strtotime($event['event_time'])
                );
                ?>

                <br>

                📍

                <?php
                echo htmlspecialchars($event['venue']);
                ?>

            </p>

        <?php endif; ?>


        <div class="message <?php echo $type; ?>">

            <?php
            echo htmlspecialchars($message);
            ?>

        </div>


        <a href="events.php"
           class="back-button">

            ← Back to Events

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