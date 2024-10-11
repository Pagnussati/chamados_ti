<?php
session_start();

// Verificando sessao
if (!isset($_SESSION['email'])) {
  header('Location: ../../frontend/pages/login.php');
  exit;
}
