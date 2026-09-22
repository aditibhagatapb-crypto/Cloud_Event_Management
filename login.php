<?php

session_start();
include 'database.php';

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND role='student'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $student = mysqli_fetch_assoc($result);

        if (password_verify($password, $student['password'])) {

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['name'];

            header("Location: events.php");
            exit();

        } else {

            $message = "Incorrect password.";

        }

    } else {

        $message = "Student account not found.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login | CampusConnect</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f6f7fb;
        }

        .login-page {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .login-box {
            width: 420px;
            background: white;
            padding: 40px;
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.10);
        }

        .login-icon {
            text-align: center;
            font-size: 50px;
            margin-bottom: 10px;
        }

        .login-box h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .login-box > p {
            text-align: center;
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

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #5b4bdb;
        }

        .login-submit {
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            color: #6b7280;
        }

        .register-link a {
            color: #5b4bdb;
            font-weight: 600;
            text-decoration: none;
        }

    </style>

</head>

<body>

<nav class="navbar">

    <div class="logo">
        Campus<span>Connect</span>
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>
        <a href="events.php">Events</a>

    </div>

</nav>


<section class="login-page">

    <div class="login-box">

        <div class="login-icon">
            🎓
        </div>

        <h1>Student Login</h1>

        <p>Login to discover and register for college events.</p>


        <?php if ($message != ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>


            <button
                type="submit"
                name="login"
                class="primary-btn login-submit"
            >
                Login →
            </button>

        </form>


        <div class="register-link">

            Don't have an account?

            <a href="register.php">
                Create an account
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