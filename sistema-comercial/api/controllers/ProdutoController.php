<?php
session_start();
require '../../database.php';
require '../models/Produto.php';

class ProdutoController {
    private $produto;

    public function __construct($db) {
        $this->produto = new Produto($db);
    }
    
  
    public function listarProduto() {
        $produtos = $this->produto->getAll();

        if (!empty($produtos)) {
            echo json_encode($produtos);
        } else {
            echo json_encode([]);
        }
    }


  
    public function cadastrarProduto() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $status = trim($_POST['status'] ?? '');

      
        if (!$nome || !$descricao|| !$status) {
            echo "Por favor, preencha todos os campos obrigatórios!";
            return;
        }
      

      
        if ($this->produto->cadastrar($nome, $descricao, $status)) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar produto!";
        }
    }

 
    public function atualizarProduto() {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') return;

        parse_str(file_get_contents("php://input"), $data);

        $id = $data['produto_id'] ?? null;
        $nome = trim($data['nome'] ?? '');
        $descricao= trim($data['descricao'] ?? '');
        $status = trim($data['status'] ?? '');

        if (!$id || !$nome || !$descricao || !$status) {
            echo "Dados insuficientes para atualizar produto.";
            return;
        }
     

        if ($this->produto->atualizar($id, $nome, $descricao, $status)) {
            echo json_encode(['status' => 'success', 'message' => 'produto atualizado.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar produto!']);
        }
    }


    public function excluirProduto() {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') return;

        parse_str(file_get_contents("php://input"), $data);

        $id = $data['delete_produto'] ?? null;
        if (!$id) {
            echo "ID do produto não fornecido.";
            return;
        }

        if ($this->produto->excluir($id)) {
            echo "Produto removido com sucesso!";
        } else {
            echo "Erro ao remover produto!";
        }
    }
}


$controller = new ProdutoController($conn);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $controller->listarProduto();
        break;
    case 'POST':
        $controller->cadastrarProduto();
        break;
    case 'PUT':
        $controller->atualizarProduto();
        break;
    case 'DELETE':
        $controller->excluirProduto();
        break;
    default:
        echo "Método inválido!";
        break;
}
?>
