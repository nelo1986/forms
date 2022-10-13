<?php
require('../../config.php');

global $USER;

$useremail = $USER->email;
$firstname = $USER->firstname;
$lastname = $USER->lastname;
$profile = $USER->profile;
$institution_name = $profile["nombre_centro"];
$certiportid= $profile["certiportid"];


echo "document.getElementById('useremail').value = '".$useremail."';";
echo "document.getElementById('institution_name').value = '".$institution_name."';";
echo "document.getElementById('name').value = '".$firstname." ".$lastname."';";
echo "document.getElementById('certiportid').value = '".$certiportid."';";
?>
