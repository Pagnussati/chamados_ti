// Populando o select
$.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados", function(data) {
  data.sort(function(a, b) {
    return a.nome.localeCompare(b.nome);
  });

  $.each(data, function(key, estado) {
    $('#state').append('<option value="' + estado.id + '">' + estado.nome + '</option>');
  });
});

$('#state').on('change', function() {
  var estadoId = $(this).val();

  // Limpa as opções de cidades
  $('#city').empty().append('<option value=""></option>');

  if (estadoId) {
    $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + estadoId + "/municipios", function(data) {
      // Popula o select de cidades
      $.each(data, function(key, cidade) {
        $('#city').append('<option value="' + cidade.id + '">' + cidade.nome + '</option>');
      });
    });
  }
});
