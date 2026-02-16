<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="../../../styles/indexfornecedores.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Fornecedores</h1>
    <header class="main-header">
        <div class="container-header">
            <a href="../../../index.php" class="btn-add">Adicionar Fornecedor</a>
            <a href="../produtos/listarproduto.php">Produtos</a>
            <a href="../produtos/produtocreate.php">Criar produto</a>
        </div>
    </header>
    
    <div class="container">
        <table id="fornecedoresTable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody id="fornecedoresBody">
              
            </tbody>
        </table>
    </div>

    <script>
    
        function carregarFornecedores() {
            $.ajax({
                url: '../../../api/controllers/FornecedorController.php',
                type: 'GET',  
                dataType: 'json',  
                success: function(data) {
                   
                    $('#fornecedoresBody').empty();

                    if (data.length > 0) {
                    
                        data.forEach(function(fornecedor) {
                            $('#fornecedoresBody').append(`
                                <tr id="fornecedor_${fornecedor.id}">
                                    <td>${fornecedor.id}</td>
                                    <td>${fornecedor.nome}</td>
                                    <td>${fornecedor.cnpj}</td>
                                    <td>${fornecedor.email}</td>
                                    <td>${fornecedor.telefone}</td>
                                    <td>${fornecedor.status}</td>
                                    <td>
                                        <a href="fornecedorview.php?id=${fornecedor.id}">Visualizar</a>
                                        <a href="fornecedoreditar.php?id=${fornecedor.id}">Editar</a>
                                        <button class="delete-btn" data-id="${fornecedor.id}">Excluir</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        
                        $('#fornecedoresBody').append('<tr><td colspan="7">Nenhum fornecedor encontrado!</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Erro ao carregar fornecedores.");
                }
            });
        }

       
        $(document).ready(function() {
            carregarFornecedores();

            
            $(document).on('click', '.delete-btn', function() {
                var fornecedorId = $(this).data('id');
                
                if (confirm('Tem certeza que deseja excluir este fornecedor?')) {
                    $.ajax({
                        url: '../../../api/controllers/FornecedorController.php', 
                        type: 'DELETE',
                        data: { delete_fornecedor: fornecedorId },
                        success: function(response) {
                            alert('Fornecedor excluído com sucesso!');
                            $('#fornecedor_' + fornecedorId).remove();
                        },
                        error: function(xhr, status, error) {
                            alert('Erro ao excluir fornecedor.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
