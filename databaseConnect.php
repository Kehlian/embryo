<?php
function Connect(){
$mysql_server="clementsjwdata.mysql.db";
$mysql_userName="clementsjwdata";
$mysql_password=file_get_contents("../password.txt");
$mysql_databaseName="clementsjwdata";

  /* Connecting, selecting database */
//$link = new mysqli($mysql_server, $mysql_userName, $mysql_password,$mysql_databaseName);
//if ($link->connect_errno) {
//    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
//   die("exiting");
//}


$link=new PDO('mysql:host=clementsjwdata.mysql.db;dbname='.$mysql_databaseName.';charset=utf8',$mysql_userName, $mysql_password);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $link;
}
?>