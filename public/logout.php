<?php

session_start();

if(isset($_SESSION['userID']))
    unset($_SESSION['userID']);

session_destroy()

?>