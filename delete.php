<?php
    session_start();
    require_once('DBConnection.php');

    if (isset($_GET['attendance_data']))
    {
        $month = $_GET['attendance_data'];

        $del_pack = $conn->query("DELETE FROM attendance_list WHERE strftime('%m', date_created) = '$month'");

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
?>