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

// Verificando se email ja existe no banco de dados
$selectEmail = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($selectEmail);
if ($result->num_rows > 0) {
    $response = ['message' => 'Este email já possui cadastro no sistema!'];
    echo json_encode($response);
    exit;
}

// Preparando a declaração SQL
$sql = "INSERT INTO usuarios (nome, data_nascimento, email, telefone, whatsapp, cidade, estado, senha)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Preparando a execução da query
if ($stmt = $conn->prepare($sql)) {
    // Bindando os parâmetros
    $stmt->bind_param("ssssssss", $name, $birthDate, $email, $telephone, $cellphone, $city, $state, $password);

    // Executando
    if ($stmt->execute()) {
        $response = ['message' => 'Usuário criado com sucesso!'];
        echo json_encode($response);
    } else {
        $response = ['message' => 'Erro ao criar usuário'];
        echo json_encode($response);
    }

    // Fechar o statement
    $stmt->close();
} else {
    $response = ['message' => 'Erro no banco de dados'];
    echo json_encode($response);
};
