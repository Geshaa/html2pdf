<?php
session_start();
require_once('../OAuthenticate.php');

$oauth 		    = new OAuthenticate();
$oauth->register($_POST['first_name'],$_POST['last_name'],$_POST['email'], $_POST['accessToken'], $_POST['accessToken'] );

