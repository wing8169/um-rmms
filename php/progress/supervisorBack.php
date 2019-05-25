<?php
session_start();
include("../config.php");

unset($_SESSION['progressid']);
unset($_SESSION['progressname']);
echo "success";
