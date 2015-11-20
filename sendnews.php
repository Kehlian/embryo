<?php

include "settings.php";
include "databaseConnect.php";
include "Security.php";
include "common.php";

//print_r($_POST);
//print_r(array_keys($_POST));

$link=Connect();
/*mysql_select_db("gestion_christiandelfosse") or die("Could not select database");*/
$title='N/A';
$title=$_POST["title"];
$title=addslashes($title);
$content=$_POST["content"];
$content=addslashes($content);
$name=$_SESSION['user']['username'];
$query="INSERT INTO News (date, title, content, signature) VALUES (NOW(), '$title', '$content','$name')";

if (!$link->query($query)) {
    echo "Insert failed : (" . $mysqli->errno . ") " . $mysqli->error. " at line ".__LINE__;
    die("Exiting");
}
//$link->close();
$link=null;
header( 'Location: sent.php' );
die();
?>