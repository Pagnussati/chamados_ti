<?php
include('database/db.php');

session_start();
session_destroy();

header('Location: http://localhost/teste-webbrain/frontend/pages/login.php');
exit;
