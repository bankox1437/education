<?php
include("../config/class_google_drive.php");
include "../config/class_database.php";
include "../config/main_function.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();

$clientID = $mainFunc->getAttr($DB, 'clientID');
$clientSecret = $mainFunc->getAttr($DB, 'clientSecret');
$redirectURI = $mainFunc->getAttr($DB, 'redirectURI');

$drive = new GoogleDriveAPI($clientID, $clientSecret, $redirectURI);
header('location: ' . $drive->getAuthUrl());
