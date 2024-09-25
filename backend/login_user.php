<?php
  session_start();
  include('database/db.php');
  
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifique a senha
        if (password_verify($password, $user['senha'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['nome'];
            echo json_encode(['message' => 'Login bem-sucedido!']);
        } else {
            echo json_encode(['message' => 'Senha incorreta']);
        }
    } else {
        echo json_encode(['message' => 'Usuário não encontrado']);
    }
  } else {
      echo json_encode(['message' => 'Dados de login inválidos']);
  }  
?>