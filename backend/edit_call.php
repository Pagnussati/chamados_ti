<?php
include('database/db.php');
session_start();

// Atribuir os dados enviados pelo formulário
$callId = isset($_POST['callId']) ? intval($_POST['callId']) : 0;
$userName = $_SESSION['name'];
$description = $_POST['description'];
date_default_timezone_set('America/Sao_Paulo');
$eventDate = date('Y-m-d H:i:s');

//Preparando a declaração SQL
$sql = "INSERT INTO historico_chamados (chamado_id, nome_usuario, descricao, data_evento)
           VALUES (?, ?, ?, ?)";

// Preparando a execução da query
if ($stmt = $conn->prepare($sql)) {
  // Bindando os parâmetros
  $stmt->bind_param("isss", $callId, $userName, $description, $eventDate);

  // Executando
  if ($stmt->execute()) {
    $response = 'Chamado alterado com sucesso!';
    echo json_encode($response);
  } else {
    $response = 'Erro ao alterar chamado.';
    echo json_encode($response);
  }
} else {
  $response = 'Erro ao preparar a query';
  echo json_encode($response);
};

// Inserindo anexos Base64
foreach ($_FILES['attachments']['tmp_name'] as $index => $tmpName) {
  $fileContent = file_get_contents($tmpName);
  $base64 = base64_encode($fileContent);

  $stmt = $conn->prepare("INSERT INTO anexos (chamado_id, arquivo_base64) VALUES (?, ?)");
  $stmt->bind_param("is", $callId, $base64);

  if (!$stmt->execute()) {
    $response = "Erro ao inserir anexo: " . $stmt->error;
    echo $response;
    exit;
  }
}
