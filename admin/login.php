<?php
session_start();
include '../database.php';

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "Admin account not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | CampusConnect</title>

    <link rel="stylesheet" href="../style.css">

    <style>
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
    </div>

</nav>

<section class="login-page">

    <div class="login-box">

        <div style="text-align:center; font-size:50px;">
            👨‍💼
        </div>

        <h1>Admin Login</h1>

        <p>Manage your college events</p>

        <?php if ($message != ""): ?>

            <div class="error">
                <?php echo $message; ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter admin email"
                    required
                >

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>

            <button
                type="submit"
                name="login"
                class="primary-btn login-submit"
            >
                Login to Dashboard →
            </button>

        </form>

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