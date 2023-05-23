<?php
session_start();
if (isset($_SESSION["is_auth_admin"]) && $_SESSION["is_auth_admin"]) {
    echo "Welcome admin!";
} else {
    header("Location: ./index.php");
}
