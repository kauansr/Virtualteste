<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relacao</title>
    <link rel="stylesheet" href="../../../styles/indexfornecedores.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Adicionar relacao</h1>
            <a href="../fornecedores/listarfornecedor.php" class="btn-add">Fornecedores</a>
            <a href="../produtos/listarproduto.php">Produtos</a>
        </div>
    </header>
    <div class="container">
        <form id="fornecedorForm" method="POST">
            <div class="form-group">
                <label for="fornecedorid">fornecedor id:</label>
                <input type="text" id="fornecedorid" name="fornecedorid" placeholder="Digite o id do fornecedor" required>
            </div>

            <div class="form-group">
                <label for="produtoid">Produto id:</label>
                <input type="text" id="produtoid" name="produtoid" placeholder="produtoid" title="Digite o id do produto" required>
            </div>

           

            <button type="submit" >Cadastrar relacao</button>
            <div id="feedback"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
        
            $('#fornecedorForm').submit(function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();  

                $.ajax({
                    url: '../../../api/controllers/ProdutoFornecedorController.php',  
                    method: 'POST',  
                    data: formData, 
                    success: function(response) {
                      
                        $('#feedback').text(response);  
                        $('#feedback').removeClass('error').addClass('success');
                    },
                    error: function(xhr, status, error) {
                       
                        $('#feedback').text('Erro ao cadastrar relacao. Tente novamente.');
                        $('#feedback').removeClass('success').addClass('error');
                    }
                });
            });
        });
    </script>
</body>
</html>
