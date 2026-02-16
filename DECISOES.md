# Modelagem do Banco de Dados:
Fornecedores:
A tabela fornecedores armazena as informações básicas de cada fornecedor, como nome, CNPJ, email, telefone e status (Ativo/Inativo).
Utilizamos um campo status com o tipo ENUM, o que facilita o controle do estado ativo ou inativo do fornecedor.

Produtos:
A tabela produtos armazena as informações dos produtos, como nome, descrição e um campo codigo_interno único, gerado por UUID. Isso garante que cada produto tenha uma identificação única no sistema.
A data de criação (criado_em) é registrada automaticamente com um valor padrão de timestamp, ajudando no rastreamento do histórico.

Produto-Fornecedor (Relacionamento Muitos-para-Muitos):
A tabela produto_fornecedor é uma tabela de junção, que permite o relacionamento muitos-para-muitos entre produtos e fornecedores.
Um produto pode ter múltiplos fornecedores e um fornecedor pode fornecer múltiplos produtos.
A combinação de produto_id e fornecedor_id é única para evitar duplicação de registros de um produto sendo fornecido por um fornecedor já cadastrado.
As chaves estrangeiras (FOREIGN KEY) asseguram a integridade referencial, com a opção ON DELETE CASCADE para garantir que, se um fornecedor ou produto for excluído, seus registros associados na tabela de junção sejam removidos automaticamente.


# Estrutura utilizada 
Uso de ENUM para Status: A escolha do tipo ENUM para o status (Ativo/Inativo) é uma maneira eficiente de representar estados limitados e facilmente controláveis.
UUID para Produtos: Usar UUID no campo codigo_interno é uma prática recomendada para garantir que a identificação do produto seja única e não dependa de valores sequenciais, o que também facilita a escalabilidade.
Relacionamento Muitos-para-Muitos: A tabela de junção produto_fornecedor permite que um produto tenha múltiplos fornecedores e vice-versa, o que é comum em sistemas comerciais onde um único produto pode ser oferecido por várias empresas.

Utilizei uma estrutura MVC(model, view, controller) simples, pois é geralmente a melhor para projetos rapidos e bem estruturados, onde model faz os comandos SQL, View são os templates onde estão html que o usuario vai enviar os dados e receber e controller que ira controlar e tratar os dados antes de ir para o model, estão na pasta api/, onde são tratados e recebendo um response.


# O que melhoraria se tivesse tempo
Campos de Data de Atualização: Adicionar um campo atualizado_em nas tabelas, para saber quando um fornecedor ou produto foi modificado pela última vez.
Validações mais robustas: Implementar validações mais robustas para o formato de CNPJ e email diretamente no banco de dados, para garantir maior integridade dos dados.
Melhoria na estrutura visual: Melhoraria e deixaria mais interativo a parte do usuario para melhor experiencia.