<?php
session_start();

$_SESSION['progressid'] = $_POST['id'];
$_SESSION['progressname'] = $_POST['full_name'];
echo "success";
