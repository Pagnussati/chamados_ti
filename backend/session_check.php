<?php
  session_start();

  // Verificando sessao
  if (!isset($_SESSION['username'])) {
      header('Location: http://localhost/teste-webbrain/frontend/pages/login.html');
      exit;
  }

?>