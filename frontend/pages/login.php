<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/login.css">
  <title>Teste | Web Brain</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../../index.html">Chamados TI</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
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
      <p class="sign-in-label">Não tem um usuário? <a href="#" id="signinButton">crie um usuário aqui!</a></p>
      <button type="submit" class="btn btn-primary" id="loginButton">Entrar</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#login-form').submit(function(event) {
        event.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
          type: 'POST',
          url: 'http://localhost/teste-webbrain/backend/login_user.php',
          data: {
            email: email,
            password: password
          },
          success: function(response) {
            if (response === "Login successful!") {
              // Redirect to dashboard or any other page
              window.location.href = 'dashboard.php';
              event.preventDefault();
            } else {
              alert(response);
            }
          }
        });
      });
    });

    $('#signinButton').click(() => {
      window.location.href = 'signin.html'
    })
  </script>
</body>

</html>