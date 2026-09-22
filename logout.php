<?php

session_start();

// Remove all student session data
session_unset();
session_destroy();

// Send student back to login page
header("Location: login.php");
exit();

?>