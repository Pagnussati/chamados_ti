<?php
   include('database/db.php');

   // Atribuir os dados enviados pelo formulário a variáveis PHP
   $name = $_POST['name'];
   $birthDate = $_POST['birthDate'];
   $email = $_POST['email'];
   $telephone = $_POST['telephone'];
   $cellphone = $_POST['cellphone'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografando a senha

   // Preparando a declaração SQL
   $sql = "INSERT INTO usuarios (nome, data_nascimento, email, telefone, whatsapp, cidade, estado, senha)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

   // Preparando a execução da query
   if ($stmt = $conn->prepare($sql)) {
       // Bindando os parâmetros
       $stmt->bind_param("ssssssss", $name, $birthDate, $email, $telephone, $cellphone, $city, $state, $password);

       // Executando
       if ($stmt->execute()) {
           echo json_encode(['success' => true]);
       } else {
           echo json_encode(['success' => false, 'message' => 'Erro ao criar o usuário']);
       }

       // Fechar o statement
       $stmt->close();
   } else {
       echo json_encode(['success' => false, 'message' => 'Erro ao preparar a query']);
   };

?>