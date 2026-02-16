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

            <div class="form-group">
                <label for="fornecedor_id">Relacionados</label>
                <p id="fornecedor_id"></p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       
        function carregarDadosProduto(id) {
            $.ajax({
                url: '../../../api/controllers/getProduto.php', 
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

        function carregarDadosRelation(id) {
    $.get('../../../api/controllers/ProdutoFornecedorController.php', { produto_id: id }, function(response) {
        var relation = JSON.parse(response);
        var container = $('#fornecedor_id');
        container.empty();

        if (relation.status !== 'success' || !Array.isArray(relation.data) || relation.data.length === 0) {
            container.text('Nenhuma relação encontrada.');
            return;
        }

      
        container.append('<button id="removerSelecionados">Remover Selecionados</button>');

        
        relation.data.forEach(function(item) {
            var fornecedorId = item.fornecedor_id || (item.fornecedor && item.fornecedor.id) || item.id || 'Não disponível';
            var relId = item.id;


            container.append(`
                <div>
                    <input type="checkbox" class="select-rel" value="${relId}">
                    Vínculo ID: ${relId} | Fornecedor ID: ${item.fornecedor_nome} | Produto ID: ${id} 
                    <button class="remover-rel" data-id="${relId}">Excluir</button>
                </div>
            `);
        });

        container.find('.remover-rel').off('click').on('click', function() {
            var relId = $(this).data('id');
            if (confirm('Deseja realmente excluir este vínculo?')) {
                $.post('../../../api/controllers/ProdutoFornecedorController.php', { action: 'remover', id: relId }, function(res) {
                    alert(res);
                    carregarDadosRelation(id);
                });
            }
        });

       
        container.find('#removerSelecionados').off('click').on('click', function() {
            var selectedIds = container.find('.select-rel:checked').map(function() { return $(this).val(); }).get();
            if (selectedIds.length === 0) {
                alert('Selecione ao menos um vínculo para remover.');
                return;
            }

            if (confirm('Deseja realmente excluir os vínculos selecionados?')) {
                $.post('../../../api/controllers/ProdutoFornecedorController.php', { action: 'removerEmMassa', ids: selectedIds }, function(res) {
                    alert(res);
                    carregarDadosRelation(id);
                });
            }
        });

    }).fail(function() {
        alert('Erro ao buscar dados da relação.');
    });
}




       
        var produtoId = new URLSearchParams(window.location.search).get('id');
        if (produtoId) {
            carregarDadosProduto(produtoId);
            carregarDadosRelation(produtoId);
        }
    </script>
</body>
</html>
