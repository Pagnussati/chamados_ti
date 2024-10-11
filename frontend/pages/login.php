<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/webbrain-logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/login.css">
  <title>Login | Chamados TI</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../../index.html">Chamados TI</a>
      <!-- <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div> -->
    </div>
  </nav>

  <div class="form-div">
    <div id="flash-message" class="alert alert-danger d-none" role="alert">
      Usuário ou senha incorretos. Tente novamente.
    </div>
    <form id="login-form">
      <div class="row mb-3">
        <label for="email" class="col-sm-2 col-form-label-lg">Email</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="email">
        </div>
      </div>
      <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label-lg">Senha</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password">
        </div>
      </div>
      <p class="sign-in-label">Não tem um usuário? <a href="./signin.php" id="signinButton">crie um usuário aqui!</a></p>
      <button type="submit" class="btn btn-primary" id="loginButton">Entrar</button>
    </form>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(() => {
      $('#login-form').submit((event) => {
        event.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();
        $('#flash-message').addClass('d-none').text(''); // limpando a mensagem anterior

        $.ajax({
          type: 'POST',
          url: '../../backend/login_user.php',
          data: {
            email: email,
            password: password
          },
          success: (response) => {
            if (response === "Login successful!") {
              window.location.href = 'dashboard.php';
            } else {
              //alert(response)
              $('#email').val('');
              $('#password').val('');
              $('#flash-message').removeClass('d-none').text(response);
            };
          }
        });

      });
    });
  </script>
</body>

</html>