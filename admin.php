<?php
session_start();
if (isset($_SESSION['is_auth']) && $_SESSION['is_auth']){
    echo 'Welcome admin!';
} else {
    header('Location: ./login.php');
}
