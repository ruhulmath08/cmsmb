<?php
$db["db_host"] = "localhost";
$db["db_user"] = "id11109952_ruhulmath08";
$db["db_pass"] = "ruhul420";
$db["db_name"] = "id11109952_cmsmb";

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connectionDB = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($connectionDB) {
   echo "Connect Successfully!!!";
}else{
echo "Cannot connect, Something wrong";
}
?>
