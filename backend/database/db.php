<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chamados_ti";
  
  // Criando conexão
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Verificando conexão
  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  } 
  echo "Conexão bem-sucedida!";
?>