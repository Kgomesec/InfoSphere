document.getElementById('postForm').addEventListener('submit', function (event) {
    // Evita o recarregamento da página ao enviar o formulário
    event.preventDefault();

    // Simulação do envio ao servidor (pode substituir por uma chamada fetch ou AJAX)
    console.log('Formulário enviado');

    // Limpa os campos do formulário
    this.reset();

    // Fecha o modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
    modal.hide();


});