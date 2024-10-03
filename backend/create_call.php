<?php
include('database/db.php');
session_start();

// Atribuir os dados enviados pelo formulário
$userId = $_SESSION['user_id'];
$userName = $_SESSION['name'];
$description = $_POST['description'];
$incidentType = $_POST['incidentType'];
date_default_timezone_set('America/Sao_Paulo');
$openingDate = date('Y-m-d H:i:s');

// Preparando a declaração SQL para inserir o chamado
$sql = "INSERT INTO chamados (usuario_id, descricao_problema, tipo_incidente, data_abertura) VALUES (?, ?, ?, ?)";

// Preparando a execução da query
if ($stmt = $conn->prepare($sql)) {
    // Bindando os parâmetros
    $stmt->bind_param("isss", $userId, $description, $incidentType, $openingDate);

    // Executando
    if ($stmt->execute()) {
        $response = ['message' => 'Chamado criado com sucesso!'];
        echo json_encode($response);

        // Recuperando o ID do chamado inserido
        $chamadoId = $stmt->insert_id;

        // Inserindo no histórico toda vez que o chamado for aberto
        $historicoSql = "INSERT INTO historico_chamados (chamado_id, nome_usuario, descricao, data_evento) VALUES (?, ?, ?, ?)";
        $descriptionHist = "Abertura do chamado";

        if ($stmt = $conn->prepare($historicoSql)) {
            $stmt->bind_param("isss", $chamadoId, $userName, $descriptionHist, $openingDate);

            if (!$stmt->execute()) {
                $response = "Erro ao inserir histórico: " . $stmt->error;
                echo $response;
                exit;
            }
        } else {
            $response = "Erro ao preparar query do histórico";
            echo json_encode($response);
            exit;
        }

        // Inserindo anexos Base64 apenas se o chamado foi criado com sucesso
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

        // Inserindo contatos telefônicos
        foreach ($_POST['contactName'] as $index => $nome) {
            $telephone = $_POST['contactPhone'][$index];
            $observation = $_POST['contactObservation'][$index];

            $stmt = $conn->prepare("INSERT INTO contatos_telefonicos (chamado_id, nome, telefone, observacao) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $chamadoId, $nome, $telephone, $observation);

            if (!$stmt->execute()) {
                $response = "Erro ao inserir contato: " . $stmt->error;
                echo $response;
                exit;
            }
        }
    } else {
        $response = ['message' => 'Erro ao criar chamado.'];
        echo json_encode($response);
    }
} else {
    $response = 'Erro ao preparar a query';
    echo json_encode($response);
}
