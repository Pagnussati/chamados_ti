<?php
include('database/db.php');

session_start();
session_destroy();

header('Location: ../../frontend/pages/login.php');
exit;
