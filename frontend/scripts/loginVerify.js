function verifyAge(birthDate) {
  var parts = birthDate.split('/');
  var birthDateObj = new Date(parts[2], parts[1] - 1, parts[0]); // ano, mês, dia

  var today = new Date();
  var age = today.getFullYear() - birthDateObj.getFullYear();
  var m = today.getMonth() - birthDateObj.getMonth();

  if (m < 0 || (m === 0 && today.getDate() < birthDateObj.getDate())) {
    age--;
  }

  if (age < 18) {
    //$('#adultWarn').text('Você precisa ter pelo menos 18 anos para se cadastrar.');
    $('#flash-message-warning').removeClass('d-none').text('Você precisa ter pelo menos 18 anos para se cadastrar.');
    return false;
  }

  $('#adultWarn').text(''); // Limpa o aviso caso a idade seja válida
  return true;
}

// Funcao de verificar senha
function verifyPassword(password, confirmPassword) {
  if (password.length < 4) {
    //$('#passwordWarn').text('A senha precisa ter pelo menos 4 caracteres!');
    $('#flash-message-warning').removeClass('d-none').text('A senha precisa ter pelo menos 4 caracteres!');
    return false;
  } else if (password !== confirmPassword) {
    //$('#passwordWarn').text('As senhas não coincidem!');
    $('#flash-message-warning').removeClass('d-none').text('As senhas não coincidem!');
    return false;
  }

  $('#passwordWarn').text(''); // Limpa o aviso caso as senhas sejam válidas
  return true;
}