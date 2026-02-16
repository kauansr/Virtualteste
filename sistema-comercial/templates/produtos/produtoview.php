<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto - Visualizar</title>
    <link rel="stylesheet" href="../../../styles/produtos.css">
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Visualizar Produto</h1>
            <a href="produtocreate.php" class="btn-add">Adicionar produto</a>
            <a href="listarproduto.php" class="btn-add">produtos</a>
        </div>
    </header>
    <div class="container">
        <form id="produtoForm" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <p id="nome"></p>
            </div>

            <div class="form-group">
                <label for="descricao">Descricao:</label>
                <p id="descricao"></p>
            </div>

            <div class="form-group">
                <label for="codigo_interno">Codigo:</label>
                <p id="codigo_interno"></p>
            </div>



            <div class="form-group">
                <label for="status">Status:</label>
                <p id="status"></p>
            </div>
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
                       
                        $('#nome').text(produto.data.nome);
                        $('#descricao').text(produto.data.descricao);
                        $('#codigo_interno').text(produto.data.codigo_interno);
                        $('#status').text(produto.data.status);
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
    </script>
</body>
</html>
