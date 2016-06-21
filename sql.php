<?php
include_once "config.php";

function sql_read($sql)
{
    $conn = connect();	
    $result = $conn->query($sql);
    $result = $result->fetch_all(MYSQLI_BOTH);
    $conn->close();
    return $result;
}

function sql_write($sql)
{
    $conn = connect();	
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function connect()
{
    $conn = new mysqli ('localhost', $GLOBALS["USER"], $GLOBALS["PASSWORD"], $GLOBALS["DATABASE"]);
    print_r($conn);
    return $conn;
}