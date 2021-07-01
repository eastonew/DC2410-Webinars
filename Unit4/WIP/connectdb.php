<?php
    $db_host = "localhost";
    $db_name = "carent";
    $username = "root";
    $password = "";

    try
    {
        $db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $ex)
    {
        echo($ex->getMessage());
    }
?>