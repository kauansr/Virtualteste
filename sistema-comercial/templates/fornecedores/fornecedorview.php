<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - Visualizar</title>
    <link rel="stylesheet" href="../../../styles/indexfornecedores.css">
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Visualizar Fornecedor</h1>
            <a href="../../../index.php" class="btn-add">Adicionar Fornecedor</a>
            <a href="listarfornecedor.php" class="btn-add">Fornecedores</a>
        </div>
    </header>
    <div class="container">
        <form id="fornecedorForm" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <p id="nome"></p>
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <p id="cnpj"></p>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <p id="email"></p>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <p id="telefone"></p>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <p id="status"></p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       
        function carregarDadosFornecedor(id) {
            $.ajax({
                url: '../../../api/fornecedores/getFornecedor.php', 
                type: 'GET',
                data: { id: id }, 
                success: function(response) {
                    var fornecedor = JSON.parse(response);
                    if (fornecedor.status === 'success') {
                       
                        $('#nome').text(fornecedor.data.nome);
                        $('#cnpj').text(fornecedor.data.cnpj);
                        $('#email').text(fornecedor.data.email);
                        $('#telefone').text(fornecedor.data.telefone);
                        $('#status').text(fornecedor.data.status);
                    } else {
                        alert('Erro ao carregar os dados do fornecedor.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erro ao buscar dados do fornecedor.');
                }
            });
        }

       
        var fornecedorId = new URLSearchParams(window.location.search).get('id');
        if (fornecedorId) {
            carregarDadosFornecedor(fornecedorId);  
        }
    </script>
</body>
</html>
