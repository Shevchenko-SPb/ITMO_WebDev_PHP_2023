<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=todo', 'root', '');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}

