<?php

include "settings.php";
include "databaseConnect.php";
include "Security.php";

//print_r($_POST);
//print_r(array_keys($_POST));

$link=Connect();
/*mysql_select_db("gestion_christiandelfosse") or die("Could not select database");*/
$class='N/A';
$class=$_POST["class_name"];
$class=addslashes($class);
$exercice=$_POST["exercice"];
$exercice=addslashes($exercice);
$description=$_POST["description"];
$description=addslashes($description);
$query="INSERT INTO Groupes (class_name, exercice, description, date) VALUES ('$class','$exercice', '$description',NOW())";

if (!$link->query($query)) {
    echo "Insert failed : (" . $mysqli->errno . ") " . $mysqli->error. " at line ".__LINE__;
    die("Exiting");
}
//$link->close();
$link=null;
header( 'Location: sent.php' );
die();
?>