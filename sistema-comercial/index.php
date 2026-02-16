<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="styles/indexfornecedores.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="main-header">
        <div class="container-header">
            <h1>Adicionar Fornecedores</h1>
            <a href="templates/fornecedores/listarfornecedor.php" class="btn-add">Fornecedores</a>
            <a href="templates/produtos/listarproduto.php">Produtos</a>
        </div>
    </header>
    <div class="container">
        <form id="fornecedorForm" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" placeholder="Apenas números" title="Digite 14 números" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="exemplo@dominio.com" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Apenas números" title="Digite 10 ou 11 números" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <button type="submit" name="create_fornecedor">Cadastrar</button>
            <div id="feedback"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
        
            $('#fornecedorForm').submit(function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();  

                $.ajax({
                    url: 'api/fornecedores/adicionarfornecedor.php',  
                    method: 'POST',  
                    data: formData, 
                    success: function(response) {
                      
                        $('#feedback').text(response);  
                        $('#feedback').removeClass('error').addClass('success');
                    },
                    error: function(xhr, status, error) {
                       
                        $('#feedback').text('Erro ao cadastrar fornecedor. Tente novamente.');
                        $('#feedback').removeClass('success').addClass('error');
                    }
                });
            });
        });
    </script>
</body>
</html>
