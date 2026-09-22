<?php

include 'database.php';

$message = "";
$success = false;

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 6) {

        $message = "Password must be at least 6 characters long.";

    } else {

        // Check if email already exists
        $check_query = "SELECT id FROM users WHERE email='$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {

            $message = "An account with this email already exists.";

        } else {

            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name, email, password, role)
                      VALUES ('$name', '$email', '$hashed_password', 'student')";

            if (mysqli_query($conn, $query)) {

                $message = "Account created successfully! 🎉";
                $success = true;

            } else {

                $message = "Something went wrong. Please try again.";

            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration | CampusConnect</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f6f7fb;
        }

        .register-page {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .register-box {
            width: 430px;
            background: white;
            padding: 40px;
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.10);
        }

        .register-icon {
            text-align: center;
            font-size: 50px;
            margin-bottom: 10px;
        }

        .register-box h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .register-box > p {
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

        .register-submit {
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .login-link {
            text-align: center;
            margin-top: 22px;
            color: #6b7280;
        }

        .login-link a {
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


<section class="register-page">

    <div class="register-box">

        <div class="register-icon">
            🎓
        </div>

        <h1>Create Account</h1>

        <p>Join CampusConnect and register for college events.</p>


        <?php if ($message != ""): ?>

            <div class="message <?php echo $success ? 'success' : 'error'; ?>">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>


        <?php if (!$success): ?>

            <form method="POST">

                <div class="form-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


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
                        placeholder="Create a password"
                        minlength="6"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="register"
                    class="primary-btn register-submit"
                >
                    Create Account →
                </button>

            </form>

        <?php endif; ?>


        <div class="login-link">

            Already have an account?

            <a href="login.php">
                Login here
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