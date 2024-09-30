<?php
include('database/db.php');
session_start();

// Atribuir os dados enviados pelo formulário
$userId = $_SESSION['user_id'];
$description = $_POST['description'];
$incidentType = $_POST['incidentType'];
$openingDate = date('Y-m-d H:i:s');

//    $response = [
//     'userId' => $userId,
//     'description' => $description,
//     'incidentType' => $incidentType,
//     'openingDate' => $openingDate
//    ];

//    echo json_encode($response);

//Preparando a declaração SQL
$sql = "INSERT INTO chamados (usuario_id, descricao_problema, tipo_incidente, data_abertura)
           VALUES (?, ?, ?, ?)";

// Preparando a execução da query
if ($stmt = $conn->prepare($sql)) {
    // Bindando os parâmetros
    $stmt->bind_param("isss", $userId, $description, $incidentType, $openingDate);

    // Executando
    if ($stmt->execute()) {
        $response = 'Chamado criado com sucesso!';
        echo json_encode($response);
    } else {
        $response = 'Erro ao criar chamado.';
        echo json_encode($response);
    }
} else {
    $response = 'Erro ao preparar a query';
    echo json_encode($response);
};

$chamadoId = $stmt->insert_id;

// Inserindo anexos Base64
foreach ($_FILES['attachments']['tmp_name'] as $index => $tmpName) {
    $fileContent = file_get_contents($tmpName);
    $base64 = base64_encode($fileContent);

    $stmt = $conn->prepare("INSERT INTO anexos (chamado_id, arquivo_base64) VALUES (?, ?)");
    $stmt->bind_param("is", $chamadoId, $base64);

    if (!$stmt->execute()) {
        $response = "Erro ao inserir anexo: " . $stmt->error;
        echo $response;
        exit;
    }
}

// Inserindo contatos telefonicos
foreach ($_POST['contactName'] as $index => $nome) {
    $telephone = $_POST['contactPhone'][$index];
    $observation = $_POST['contactObservation'][$index];

    $stmt = $conn->prepare("INSERT INTO contatos_telefonicos (chamado_id, nome, telefone, observacao) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $chamadoId, $nome, $telephone, $observation);

    if (!$stmt->execute()) {
        $response = "Erro ao inserir contato: " . $stmt->error;
        echo  $response;
        exit;
    }
}
