<?php
include 'config.php';

session_start();
if( ! (isset($_SESSION['userID']) && $_SESSION['userID'] != '') ){
    header ("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>html2pdf</title>
    <link rel="stylesheet" href="assets/front/css/style.css">
</head>
<body id="target">
<header class="head">
    <div class="wrapper">
        <ul>
            <li><a href="dashboard.php">Generate New</a></li>
        </ul>
        <span id="logOutButton" class="btn"><span>Log out</span></span>
    </div>
</header>
<main>
    <div class="wrapper listPDF">
        <table id="createdPDFTable" class="table">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</main>

<script src="assets/front/js/scripts.js"></script>
<!-- Delete livereload.js on production -->
<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
