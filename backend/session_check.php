<?php
session_start();

// Verificando sessao
if (!isset($_SESSION['email'])) {
  header('Location: http://localhost/teste-webbrain/frontend/pages/login.html');
  exit;
}
