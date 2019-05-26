<?php

//Get Heroku ClearDB connection information
$cleardb_url      = parse_url("mysql://bca398946056c0:db2a3802@us-cdbr-iron-east-02.cleardb.net/heroku_8ac57aa6a74cd67?reconnect=true");

$cleardb_server   = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db       = substr($cleardb_url["path"], 1);



$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'    => '',
    'hostname' => $cleardb_server,
    'username' => $cleardb_username,
    'password' => $cleardb_password,
    'database' => $cleardb_db,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    // 'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$servername = $db['default']['hostname'];
$database = $db['default']['database'];
$username = $db['default']['username'];
$password = $db['default']['password'];

// $servername = "127.0.0.1";
// $database = "umrmms";
// $username = "jiaxiong";
// $password = "jiaxiong";

$conn = new mysqli($servername, $username, $password, $database);
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
// echo "Database connnected successfully<br>";
