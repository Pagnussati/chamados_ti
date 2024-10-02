<?php
session_start();
include 'database/db.php';

// Supondo que o ID do usuário logado esteja armazenado na sessão
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM chamados WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$chamados = [];
while ($chamado = $result->fetch_assoc()) {
  $chamados[] = $chamado;
}

echo json_encode($chamados);
