<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores editar</title>
    <link rel="stylesheet" href="../../../styles/indexfornecedores.css">
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Editar Fornecedor</h1>
            <a href="listarfornecedor.php" class="btn-add">Fornecedores</a>
            <a href="../../../index.php" class="btn-add">Adicionar Fornecedores</a>
        </div>
    </header>
    <div class="container">
        
        <form id="fornecedorForm">
            <input type="hidden" id="fornecedor_id">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" placeholder="Apenas números" title="Digite 14 números">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="exemplo@dominio.com" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Apenas números" title="Digite 10 ou 11 números">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <button type="button" id="submitBtn">Editar</button>
            <div id="feedback"></div>
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
                        $('#fornecedor_id').val(fornecedor.data.id);
                        $('#nome').val(fornecedor.data.nome);
                        $('#cnpj').val(fornecedor.data.cnpj);
                        $('#email').val(fornecedor.data.email);
                        $('#telefone').val(fornecedor.data.telefone);
                        $('#status').val(fornecedor.data.status);
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

      
        $('#submitBtn').on('click', function() {
            var fornecedor_id = $('#fornecedor_id').val()
            var nome = $('#nome').val();
            var cnpj = $('#cnpj').val();
            var email = $('#email').val();
            var telefone = $('#telefone').val();
            var status = $('#status').val();

            if (nome && cnpj && email && telefone && status) {
                $.ajax({
                    url: '../../../api/fornecedores/adicionarfornecedor.php',
                    type: 'PUT',
                    data: {
                        fornecedor_id: fornecedorId,
                        nome: nome,
                        cnpj: cnpj,
                        email: email,
                        telefone: telefone,
                        status: status
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            $('#feedback').text(result.message).css('color', 'green');
                        } else {
                            $('#feedback').text(result.message).css('color', 'red');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#feedback').text('Erro ao editar fornecedor.').css('color', 'red');
                    }
                });
            } else {
                $('#feedback').text('Por favor, preencha todos os campos corretamente.').css('color', 'red');
            }
        });
    </script>
</body>
</html>
