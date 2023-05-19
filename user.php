<?php
session_start();

if (isset($_SESSION['is_auth']) && $_SESSION['is_auth']){
    echo "Welcome user!";
} else {
    header('Location: ./login.php');
}