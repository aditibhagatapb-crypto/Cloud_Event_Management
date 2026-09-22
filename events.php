<?php

session_start();
include 'database.php';

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Events | CampusConnect</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .events-page {
            padding: 70px 7%;
        }

        .event-page-header {
            text-align: center;
            margin-bottom: 45px;
        }

        .event-page-header h1 {
            font-size: 42px;
            margin-bottom: 12px;
            color: #111827;
        }

        .event-page-header p {
            color: #6b7280;
        }

        .empty-events {
            text-align: center;
            background: white;
            padding: 60px 20px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        }

        .empty-events .icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .event-details {
            margin: 12px 0 18px;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.8;
        }

        .login-message {
            margin-top: 12px;
            font-size: 13px;
            color: #6b7280;
        }

        @media (max-width: 700px) {

            .event-page-header h1 {
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

            <a href="index.php">Home</a>

            <a href="events.php">Events</a>

            <a href="index.php#features">Features</a>

            <?php if (isset($_SESSION['student_id'])): ?>

                <a href="logout.php" class="login-btn">
                    Logout
                </a>

            <?php else: ?>

                <a href="login.php" class="login-btn">
                    Login
                </a>

            <?php endif; ?>

        </div>

    </nav>


    <!-- EVENTS -->

    <section class="events-page">

        <div class="event-page-header">

            <span class="hero-tag">
                🎓 Campus Events
            </span>

            <h1>Discover Upcoming Events</h1>

            <p>
                Find events, workshops and activities happening on campus.
            </p>

        </div>


        <?php if (mysqli_num_rows($result) > 0): ?>

            <div class="events-grid">

                <?php while ($event = mysqli_fetch_assoc($result)): ?>

                    <div class="event-card">

                        <div class="event-top">
                            🎉
                        </div>

                        <div class="event-info">

                            <span class="event-date">

                                📅

                                <?php
                                echo date(
                                    "d M Y",
                                    strtotime($event['event_date'])
                                );
                                ?>

                            </span>


                            <h3>

                                <?php
                                echo htmlspecialchars($event['title']);
                                ?>

                            </h3>


                            <p>

                                <?php
                                echo htmlspecialchars($event['description']);
                                ?>

                            </p>


                            <div class="event-details">

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

                                <br>


                                👥

                                Capacity:

                                <?php
                                echo htmlspecialchars($event['capacity']);
                                ?>

                            </div>


                            <!-- REGISTER BUTTON -->

                            <?php if (isset($_SESSION['student_id'])): ?>

                                <a
                                    href="register_event.php?event_id=<?php echo $event['id']; ?>"
                                    class="primary-btn"
                                >
                                    Register Now →
                                </a>

                            <?php else: ?>

                                <a
                                    href="login.php"
                                    class="primary-btn"
                                >
                                    Login to Register →
                                </a>

                                <div class="login-message">
                                    Login to register for this event.
                                </div>

                            <?php endif; ?>


                        </div>

                    </div>

                <?php endwhile; ?>

            </div>


        <?php else: ?>


            <div class="empty-events">

                <div class="icon">
                    📅
                </div>

                <h2>
                    No Events Available Yet
                </h2>

                <p>
                    New college events will appear here when the administrator
                    adds them.
                </p>

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