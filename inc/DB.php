<?php
$db["db_host"] = "sql12.freemysqlhosting.net";
$db["db_user"] = "sql12310720";
$db["db_pass"] = "ruhul && 01745077380";
$db["db_name"] = "WWalV4k3dL";

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
