<?php
include 'database/db.php';

// Selecionando tudo da tabela
$query = "SELECT * FROM chamados";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$chamados = [];
while ($chamado = $result->fetch_assoc()) {
  $chamados[] = $chamado;
}

echo json_encode($chamados);
