<?php

session_start();
include '../database.php';


// Check admin login
if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();

}


// Delete event
if (isset($_GET['delete'])) {

    $event_id = intval($_GET['delete']);

    $delete_query = "DELETE FROM events WHERE id = ?";

    $stmt = mysqli_prepare($conn, $delete_query);

    mysqli_stmt_bind_param($stmt, "i", $event_id);

    mysqli_stmt_execute($stmt);

    header("Location: manage_events.php");
    exit();

}


// Get all events with registration count
$query = "
    SELECT 
        events.id,
        events.title,
        events.description,
        events.event_date,
        events.event_time,
        events.venue,
        events.capacity,
        COUNT(registrations.id) AS registered_count
    FROM events
    LEFT JOIN registrations
        ON events.id = registrations.event_id
    GROUP BY
        events.id,
        events.title,
        events.description,
        events.event_date,
        events.event_time,
        events.venue,
        events.capacity
    ORDER BY events.event_date ASC
";


$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Events | CampusConnect</title>

    <link rel="stylesheet" href="../style.css">


    <style>

        body {
            background: #f6f7fb;
        }


        .admin-page {

            padding: 60px 7%;

            min-height: 70vh;

        }


        .page-header {

            text-align: center;

            margin-bottom: 45px;

        }


        .page-header h1 {

            font-size: 40px;

            color: #111827;

            margin-bottom: 10px;

        }


        .page-header p {

            color: #6b7280;

        }


        .event-table-box {

            background: white;

            border-radius: 20px;

            padding: 25px;

            box-shadow:
                0 10px 30px rgba(0,0,0,0.07);

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 900px;

        }


        th {

            text-align: left;

            padding: 16px;

            background: #f8f7ff;

            color: #374151;

            font-size: 14px;

        }


        td {

            padding: 18px 16px;

            border-bottom: 1px solid #eee;

            color: #4b5563;

            font-size: 14px;

        }


        td strong {

            color: #111827;

        }


        .registration-count {

            display: inline-block;

            padding: 7px 12px;

            background: #ede9fe;

            color: #5b4bdb;

            border-radius: 20px;

            font-weight: 700;

            font-size: 13px;

        }


        .full {

            background: #fee2e2;

            color: #991b1b;

        }


        .edit-btn {

            display: inline-block;

            padding: 8px 13px;

            background: #ede9fe;

            color: #5b4bdb;

            text-decoration: none;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

            margin-right: 5px;

        }


        .edit-btn:hover {

            background: #ddd6fe;

        }


        .delete-btn {

            display: inline-block;

            padding: 8px 13px;

            background: #fee2e2;

            color: #991b1b;

            text-decoration: none;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

        }


        .delete-btn:hover {

            background: #fecaca;

        }


        .empty-box {

            text-align: center;

            padding: 60px 20px;

            color: #6b7280;

        }


        .empty-box .icon {

            font-size: 55px;

            margin-bottom: 15px;

        }


        .top-actions {

            display: flex;

            justify-content: center;

            gap: 15px;

            margin-top: 25px;

        }


        .top-actions a {

            text-decoration: none;

        }


        .action-buttons {

            display: flex;

            align-items: center;

            gap: 5px;

            flex-wrap: wrap;

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



<!-- PAGE -->

<section class="admin-page">


    <div class="page-header">

        <span class="hero-tag">
            ⚙️ Administration
        </span>


        <h1>
            Manage Events
        </h1>


        <p>
            View events and monitor student registrations.
        </p>


        <div class="top-actions">

            <a href="add_event.php"
               class="primary-btn">

                + Add New Event

            </a>

        </div>

    </div>



    <div class="event-table-box">


        <?php if (mysqli_num_rows($result) > 0): ?>


            <table>

                <thead>

                    <tr>

                        <th>
                            Event
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Time
                        </th>

                        <th>
                            Venue
                        </th>

                        <th>
                            Registrations
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    <?php while ($event = mysqli_fetch_assoc($result)): ?>


                        <tr>


                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $event['title']
                                    );
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <?php
                                echo date(
                                    "d M Y",
                                    strtotime(
                                        $event['event_date']
                                    )
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo date(
                                    "h:i A",
                                    strtotime(
                                        $event['event_time']
                                    )
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $event['venue']
                                );
                                ?>

                            </td>


                            <td>

                                <?php

                                $registered =
                                    $event['registered_count'];

                                $capacity =
                                    $event['capacity'];

                                ?>


                                <span
                                    class="registration-count
                                    <?php
                                    echo
                                        ($registered >= $capacity)
                                        ? 'full'
                                        : '';
                                    ?>"
                                >

                                    👥

                                    <?php
                                    echo $registered;
                                    ?>

                                    /

                                    <?php
                                    echo $capacity;
                                    ?>

                                </span>


                            </td>


                            <td>

                                <div class="action-buttons">


                                    <!-- EDIT -->

                                    <a
                                        href="edit_event.php?id=<?php echo $event['id']; ?>"
                                        class="edit-btn"
                                    >

                                        Edit

                                    </a>



                                    <!-- DELETE -->

                                    <a
                                        href="manage_events.php?delete=<?php echo $event['id']; ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this event?');"
                                    >

                                        Delete

                                    </a>


                                </div>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                </tbody>

            </table>


        <?php else: ?>


            <div class="empty-box">

                <div class="icon">
                    📅
                </div>


                <h2>
                    No Events Found
                </h2>


                <p>
                    Add your first college event to get started.
                </p>

            </div>


        <?php endif; ?>


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