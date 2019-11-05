<?php
$db["db_host"] = "remotemysql.com";
$db["db_user"] = "3SWBCXYiSd";
$db["db_pass"] = "iprWkMh8Og";
$db["db_name"] = "3SWBCXYiSd";

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connectionDB = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
// if ($connectionDB) {
//    echo "Connect Successfully!!!";
// }else{
// echo "Cannot connect, Something wrong";
// }
?>
