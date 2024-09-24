<?php
   include('database/db.php');

   // Verificar se os dados foram recebidos corretamente
   if (isset($_POST['name']) && isset($_POST['birthDate']) && isset($_POST['email']) && isset($_POST['telephone']) &&
       isset($_POST['cellphone']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['password'])) {
 
     // Atribuir os dados enviados pelo formulário a variáveis PHP
     $name = $_POST['name'];
     $birthDate = $_POST['birthDate'];
     $email = $_POST['email'];
     $telephone = $_POST['telephone'];
     $cellphone = $_POST['cellphone'];
     $city = $_POST['city'];
     $state = $_POST['state'];
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha
 
     // Preparar a declaração SQL usando mysqli para prevenir SQL Injection
     $sql = "INSERT INTO usuarios (nome, data_nascimento, email, telefone, whatsapp, cidade, estado, senha)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
 
     // Preparar a execução da query
     if ($stmt = $conn->prepare($sql)) {
         // Associar os parâmetros
         $stmt->bind_param("ssssssss", $name, $birthDate, $email, $telephone, $cellphone, $city, $state, $password);
 
         // Executar a query
         if ($stmt->execute()) {
             echo json_encode(['success' => true]);
         } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao criar o usuário']);
         }
 
         // Fechar o statement
         $stmt->close();
     } else {
         echo json_encode(['success' => false, 'message' => 'Erro ao preparar a query']);
     }
   } else {
     echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
   }
 
   // Fechar a conexão
   $conn->close();
?>