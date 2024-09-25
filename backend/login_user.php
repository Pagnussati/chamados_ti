<?php
    include('database/db.php');

    if (isset($_POST['email']) && isset($_POST['password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
  
      $query = "SELECT * FROM usuarios WHERE email = '$email'";
      $result = $conn->query($query);
  
      if ($result->num_rows > 0) {
          $user_data = $result->fetch_assoc();
          if (password_verify($password, $user_data['senha'])) {
              // Create session
              session_start();
              $_SESSION['email'] = $email;
              echo "Login successful!";
          } else {
              echo "Invalid password";
          }
      } else {
          echo "User not found";
      }
  }
?>