<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos editar</title>
    <link rel="stylesheet" href="../../../styles/produtos.css">
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Editar produto</h1>
            <a href="listarproduto.php" class="btn-add">Produtos</a>
            <a href="produtocreate.php" class="btn-add">Adicionar produtos</a>
        </div>
    </header>
    <div class="container">
        
        <form id="produtoForm">
            <input type="hidden" id="produto_id">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descricao:</label>
                <input type="text" id="descricao" name="descricao" placeholder="Descricao" title="Descricao">
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
       
        function carregarDadosProduto(id) {
            $.ajax({
                url: '../../../api/produtos/getProduto.php', 
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    var produto = JSON.parse(response);
                    if (produto.status === 'success') {
                        $('#produto_id').val(produto.data.id);
                        $('#nome').val(produto.data.nome);
                        $('#descricao').val(produto.data.descricao);
                        $('#status').val(produto.data.status);
                    } else {
                        alert('Erro ao carregar os dados do produto.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erro ao buscar dados do produto.');
                }
            });
        }

        
        var produtoId = new URLSearchParams(window.location.search).get('id');
        if (produtoId) {
            carregarDadosProduto(produtoId);
        }

      
        $('#submitBtn').on('click', function() {
            var produto_id = $('#produto_id').val()
            var nome = $('#nome').val();
            var descricao = $('#descricao').val();
            var status = $('#status').val();

            if (nome && descricao  && status) {
                $.ajax({
                    url: '../../../api/produtos/produtoapi.php',
                    type: 'PUT',
                    data: {
                        produto_id: produtoId,
                        nome: nome,
                        descricao: descricao,
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
                        $('#feedback').text('Erro ao editar produto.').css('color', 'red');
                    }
                });
            } else {
                $('#feedback').text('Por favor, preencha todos os campos corretamente.').css('color', 'red');
            }
        });
    </script>
</body>
</html>
