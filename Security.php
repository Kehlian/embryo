<?php
function sch_encrypt($string){
  return md5($string."Mon premier site 2015");
}
function sch_verify($string, $encrypted){
  return md5($string."Mon premier site 2015")==$encrypted;
}
?>