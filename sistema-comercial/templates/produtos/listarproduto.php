<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../../../styles/produtos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Produtos</h1>
    <header class="main-header">
        <div class="container-header">
            <a href="produtocreate.php" class="btn-add">Adicionar produto</a>
            <a href="../fornecedores/listarfornecedor.php">Fornecedores</a>
        </div>
    </header>
    
    <div class="container">
        <table id="produtosTable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Descricao</th>
                    <th>Codigo</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody id="produtosBody">
              
            </tbody>
        </table>
    </div>

    <script>
    
        function carregarProduto() {
            $.ajax({
                url: '../../../api/produtos/listar_produto.php',
                type: 'GET',  
                dataType: 'json',  
                success: function(data) {
                   
                    $('#produtosBody').empty();

                    if (data.length > 0) {
                    
                        data.forEach(function(produto) {
                            $('#produtosBody').append(`
                                <tr id="produto_${produto.id}">
                                    <td>${produto.id}</td>
                                    <td>${produto.nome}</td>
                                    <td>${produto.descricao}</td>
                                    <td>${produto.codigo_interno}</td>
                                    <td>${produto.status}</td>
                                    <td>
                                        <a href="produtoview.php?id=${produto.id}">Visualizar</a>
                                        <a href="produtoeditar.php?id=${produto.id}">Editar</a>
                                        <button class="delete-btn" data-id="${produto.id}">Excluir</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        
                        $('#produtosBody').append('<tr><td colspan="7">Nenhum produto encontrado!</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Erro ao carregar produto.");
                }
            });
        }

       
        $(document).ready(function() {
            carregarProduto();

            
            $(document).on('click', '.delete-btn', function() {
                var produtoId = $(this).data('id');
                
                if (confirm('Tem certeza que deseja excluir este produto?')) {
                    $.ajax({
                        url: '../../../api/produtos/produtoapi.php', 
                        type: 'DELETE',
                        data: { delete_produto: produtoId },
                        success: function(response) {
                            alert('Produto excluído com sucesso!');
                            $('#produto_' + produtoId).remove();
                        },
                        error: function(xhr, status, error) {
                            alert('Erro ao excluir produto.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
