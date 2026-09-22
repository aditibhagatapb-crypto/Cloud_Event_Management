<?php

include 'database.php';


// Get upcoming events from database
$query = "
    SELECT *
    FROM events
    WHERE event_date >= CURDATE()
    ORDER BY event_date ASC
    LIMIT 3
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>CampusConnect | College Event Management</title>

    <link rel="stylesheet" href="style.css">

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

        <a href="index.php#features">
            Features
        </a>

        <a href="login.php"
           class="login-btn">

            Login

        </a>

    </div>

</nav>



<!-- HERO SECTION -->

<section class="hero">

    <div class="hero-content">

        <span class="hero-tag">

            🎓 College Events Made Simple

        </span>


        <h1>

            Discover.
            <span>Register.</span>
            Experience.

        </h1>


        <p>

            Discover exciting college events, register in seconds,
            and keep track of all your registrations in one simple
            and organized platform.

        </p>


        <div class="hero-buttons">

            <a href="events.php"
               class="primary-btn">

                Explore Events →

            </a>


            <a href="register.php"
               class="secondary-btn">

                Create Account

            </a>

        </div>

    </div>


    <div class="hero-image">

        🎓

    </div>

</section>



<!-- UPCOMING EVENTS -->

<section class="events-section">

    <div class="section-heading">

        <span class="hero-tag">

            🎉 Upcoming Events

        </span>


        <h2>

            Explore What's Happening on Campus

        </h2>


        <p>

            Discover exciting events and activities organized
            for the college community.

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
                                "d F Y",
                                strtotime(
                                    $event['event_date']
                                )
                            );

                            ?>

                        </span>


                        <h3>

                            <?php

                            echo htmlspecialchars(
                                $event['title']
                            );

                            ?>

                        </h3>


                        <p>

                            <?php

                            echo htmlspecialchars(
                                $event['description']
                            );

                            ?>

                        </p>


                        <div class="event-details"
                             style="
                                margin: 12px 0 15px;
                                color: #6b7280;
                                font-size: 13px;
                                line-height: 1.8;
                             ">

                            🕐

                            <?php

                            echo date(
                                "h:i A",
                                strtotime(
                                    $event['event_time']
                                )
                            );

                            ?>

                            <br>


                            📍

                            <?php

                            echo htmlspecialchars(
                                $event['venue']
                            );

                            ?>

                        </div>


                        <a href="events.php"
                           class="primary-btn">

                            View Event →

                        </a>


                    </div>


                </div>


            <?php endwhile; ?>


        </div>


    <?php else: ?>


        <div style="
            text-align:center;
            padding:50px 20px;
            background:white;
            border-radius:20px;
        ">

            <div style="
                font-size:50px;
                margin-bottom:15px;
            ">

                📅

            </div>


            <h3>

                No Upcoming Events

            </h3>


            <p style="
                color:#6b7280;
                margin-top:10px;
            ">

                New college events will appear here when
                the administrator adds them.

            </p>

        </div>


    <?php endif; ?>


</section>



<!-- FEATURES -->

<section class="features-section"
         id="features">


    <div class="section-heading">

        <span class="hero-tag">

            ✨ Everything in One Place

        </span>


        <h2>

            Simple, Organized & Convenient

        </h2>


        <p>

            Everything students need to discover and manage
            college events.

        </p>

    </div>



    <div class="features-grid">


        <div class="feature-card">


            <div class="feature-icon">

                📅

            </div>


            <h3>

                Discover Events

            </h3>


            <p>

                Browse upcoming college events and find
                activities that interest you.

            </p>

        </div>



        <div class="feature-card">


            <div class="feature-icon">

                📝

            </div>


            <h3>

                Easy Registration

            </h3>


            <p>

                Register for events quickly while avoiding
                duplicate registrations.

            </p>

        </div>



        <div class="feature-card">


            <div class="feature-icon">

                🔔

            </div>


            <h3>

                Stay Updated

            </h3>


            <p>

                Receive important event information and
                registration updates.

            </p>

        </div>


    </div>


</section>



<!-- FOOTER -->

<footer>

    <h3>

        CampusConnect

    </h3>


    <p>

        Cloud-Based College Event Registration and
        Management System

    </p>


    <br>


    <p>

        © 2026 CampusConnect. College Project.

    </p>

</footer>


</body>

</html>