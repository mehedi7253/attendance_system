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

    if (isset($_GET['delete_employee']))
    {
        $employee = $_GET['delete_employee'];

        $conn->query("DELETE FROM employee_list WHERE employee_id = '$employee'");
        $conn->query("DELETE FROM user_list WHERE user_id = '$employee'");

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
?>