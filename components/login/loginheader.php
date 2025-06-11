<?php
//PUT THIS HEADER ON TOP OF EACH UNIQUE PAGE
session_start();

if (!isset($_SESSION['username'])) {
    header("location: components/login/main_login.php");
}
