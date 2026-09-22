<?php

session_start();
include 'database.php';


// Student must be logged in
if (!isset($_SESSION['student_id'])) {

    header("Location: login.php");
    exit();

}


$student_id = $_SESSION['student_id'];


// Get student's registered events
$query = "
    SELECT 
        registrations.id AS registration_id,
        events.title,
        events.description,
        events.event_date,
        events.event_time,
        events.venue
    FROM registrations
    INNER JOIN events
        ON registrations.event_id = events.id
    WHERE registrations.user_id = ?
    ORDER BY events.event_date ASC
";


$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $student_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Registrations | CampusConnect</title>

    <link rel="stylesheet" href="style.css">


    <style>

        body {
            background: #f6f7fb;
        }


        .registrations-page {

            padding: 70px 7%;

            min-height: 70vh;

        }


        .page-header {

            text-align: center;

            margin-bottom: 45px;

        }


        .page-header h1 {

            font-size: 42px;

            color: #111827;

            margin-bottom: 12px;

        }


        .page-header p {

            color: #6b7280;

        }


        .registration-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(300px, 1fr));

            gap: 25px;

        }


        .registration-card {

            background: white;

            border-radius: 20px;

            padding: 28px;

            box-shadow:
                0 8px 25px rgba(0,0,0,0.07);

        }


        .registration-status {

            display: inline-block;

            background: #dcfce7;

            color: #166534;

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 15px;

        }


        .registration-card h2 {

            font-size: 22px;

            margin-bottom: 12px;

            color: #111827;

        }


        .registration-card p {

            color: #6b7280;

            line-height: 1.6;

        }


        .event-info {

            margin-top: 18px;

            color: #4b5563;

            line-height: 2;

            font-size: 14px;

        }


        .empty-box {

            max-width: 600px;

            margin: 0 auto;

            background: white;

            padding: 60px 25px;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 8px 25px rgba(0,0,0,0.07);

        }


        .empty-icon {

            font-size: 60px;

            margin-bottom: 15px;

        }


        .empty-box h2 {

            margin-bottom: 10px;

        }


        .empty-box p {

            color: #6b7280;

            margin-bottom: 25px;

        }


        .back-button {

            display: inline-block;

            padding: 12px 22px;

            background: #5b4bdb;

            color: white;

            text-decoration: none;

            border-radius: 9px;

            font-weight: 600;

        }


        @media (max-width: 700px) {

            .page-header h1 {

                font-size: 32px;

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

        <a href="index.php">
            Home
        </a>

        <a href="events.php">
            Events
        </a>

        <a href="my_registrations.php">
            My Registrations
        </a>

        <a href="logout.php"
           class="login-btn">

            Logout

        </a>

    </div>

</nav>



<!-- PAGE -->

<section class="registrations-page">


    <div class="page-header">

        <span class="hero-tag">
            🎟️ Your Events
        </span>


        <h1>
            My Registrations
        </h1>


        <p>
            View all the college events you have registered for.
        </p>

    </div>



    <?php if (mysqli_num_rows($result) > 0): ?>


        <div class="registration-grid">


            <?php while ($registration = mysqli_fetch_assoc($result)): ?>


                <div class="registration-card">


                    <span class="registration-status">

                        ✓ Registered

                    </span>


                    <h2>

                        <?php
                        echo htmlspecialchars(
                            $registration['title']
                        );
                        ?>

                    </h2>


                    <p>

                        <?php
                        echo htmlspecialchars(
                            $registration['description']
                        );
                        ?>

                    </p>


                    <div class="event-info">

                        📅

                        <?php
                        echo date(
                            "d M Y",
                            strtotime(
                                $registration['event_date']
                            )
                        );
                        ?>


                        <br>


                        🕐

                        <?php
                        echo date(
                            "h:i A",
                            strtotime(
                                $registration['event_time']
                            )
                        );
                        ?>


                        <br>


                        📍

                        <?php
                        echo htmlspecialchars(
                            $registration['venue']
                        );
                        ?>

                    </div>


                </div>


            <?php endwhile; ?>


        </div>


    <?php else: ?>


        <div class="empty-box">

            <div class="empty-icon">
                🎟️
            </div>


            <h2>
                No Registrations Yet
            </h2>


            <p>
                You haven't registered for any college
                events yet.
            </p>


            <a href="events.php"
               class="back-button">

                Explore Events →

            </a>

        </div>


    <?php endif; ?>


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