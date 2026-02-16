1️⃣ Modelagem do Banco de Dados

O banco foi modelado com três tabelas principais:

fornecedores: armazena informações de cada fornecedor (nome, CNPJ, e-mail, telefone, status, data de criação).

produtos: armazena informações de cada produto (nome, descrição, código interno único, status, data de criação).

produto_fornecedor: tabela de vínculo muitos-para-muitos entre produtos e fornecedores, garantindo que um produto possa ter vários fornecedores e vice-versa. Inclui chave única para evitar duplicidade e integridade referencial via FOREIGN KEY com ON DELETE CASCADE.

Motivo da escolha:
Essa modelagem normalizada evita redundância, mantém integridade referencial e permite consultas com JOIN eficientes para listar produtos e fornecedores vinculados.

2️⃣ Estrutura Técnica e Organização

O projeto foi estruturado em MVC simples:

/controllers → recebe requisições e gerencia lógica de fluxo.
/models → representa as entidades do sistema.
/views → interface HTML + jQuery + AJAX.

Separação mínima entre lógica de negócio, acesso a dados e apresentação.
Queries SQL centralizadas nos models, evitando mistura de código SQL na view.

Reutilizei uma simples função para deixar o nome dos fornecedores e produtos mais legiveis.

Motivo da escolha:
Essa organização facilita manutenção, extensão futura e leitura do código, mesmo em projetos simples.


4️⃣ Melhorias Futuras

Criar funções ou classes genéricas para reduzir repetição de código.
Adicionar testes unitários simples para validar regras de negócio.
Implementar histórico de vínculos.
Aprimorar feedback visual e filtros para melhor experiência do usuário.