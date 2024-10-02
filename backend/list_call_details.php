<?php
include 'database/db.php';

$idChamado = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar os detalhes do chamado
$queryChamado = "SELECT * FROM chamados WHERE id = ?";
$stmtChamado = $conn->prepare($queryChamado);
$stmtChamado->bind_param("i", $idChamado);
$stmtChamado->execute();
$resultChamado = $stmtChamado->get_result();

if ($resultChamado->num_rows == 0) {
  echo json_encode(['error' => 'Chamado não encontrado.']);
  exit;
}

$chamado = $resultChamado->fetch_assoc();

// Consultar histórico
$queryHistorico = "SELECT * FROM historico_chamados WHERE chamado_id = ?";
$stmtHistorico = $conn->prepare($queryHistorico);
$stmtHistorico->bind_param("i", $idChamado);
$stmtHistorico->execute();
$resultHistorico = $stmtHistorico->get_result();

$historico = [];
while ($hist = $resultHistorico->fetch_assoc()) {
  $historico[] = $hist;
}

// Consultar anexos
$queryAnexos = "SELECT * FROM anexos WHERE chamado_id = ?";
$stmtAnexos = $conn->prepare($queryAnexos);
$stmtAnexos->bind_param("i", $idChamado);
$stmtAnexos->execute();
$resultAnexos = $stmtAnexos->get_result();

$anexos = [];
while ($anexo = $resultAnexos->fetch_assoc()) {
  $anexos[] = $anexo;
}

// Adicionar histórico e anexos ao chamado
$chamado['historico'] = $historico;
$chamado['anexos'] = $anexos;

$stmtChamado->close();
$stmtHistorico->close();
$stmtAnexos->close();
$conn->close();

echo json_encode($chamado);
