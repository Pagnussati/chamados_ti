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

       // Fechar o statement
       $stmt->close();
   } else {
    $response = 'Erro ao preparar a query';
    echo json_encode($response);
   };

?>