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
    <header class="main-header">
        <div class="container-header">
            <h1>Adicionar Produto</h1>
            <a href="listarproduto.php" class="btn-add">Produtos</a>
        </div>
    </header>
    <div class="container">
        <form id="produtoForm" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descricao:</label>
                <input type="text" id="descricao" name="descricao" placeholder="descricao" title="descricao" required>
            </div>


            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <button type="submit" name="create_produto">Cadastrar produto</button>
            <div id="feedback"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
        
            $('#produtoForm').submit(function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();  

                $.ajax({
                    url: '../../../api/controllers/ProdutoController.php',  
                    method: 'POST',  
                    data: formData, 
                    success: function(response) {
                      
                        $('#feedback').text(response);  
                        $('#feedback').removeClass('error').addClass('success');
                    },
                    error: function(xhr, status, error) {
                       
                        $('#feedback').text('Erro ao cadastrar produto. Tente novamente.');
                        $('#feedback').removeClass('success').addClass('error');
                    }
                });
            });
        });
    </script>
</body>
</html>
