<?php
session_start();
require '../../database.php';
require '../models/Relation.php';

class ProdutoFornecedorController {

    private $relation;

    public function __construct($db) {
        $this->relation = new ProdutoFornecedor($db);
    }

    
    public function cadastrar() {
    $fornecedorid = intval($_POST['fornecedorid'] ?? 0);
    $produtoid    = intval($_POST['produtoid'] ?? 0);

    if (!$fornecedorid || !$produtoid) {
        echo "Campos obrigatórios.";
        return;
    }

    
    $verificacao = $this->relation->verificarRelacionamento($fornecedorid, $produtoid);
    if ($verificacao !== true) {
        echo $verificacao; 
        return;
    }

    
    if ($this->relation->cadastrar($fornecedorid, $produtoid)) {
        echo "Relação cadastrada com sucesso!";
    } else {
        echo "Erro desconhecido ao cadastrar relação.";
    }
}


   
    public function listarPorProduto() {
        $produto_id = intval($_GET['produto_id'] ?? 0);
        if (!$produto_id) {
            echo json_encode([]);
            return;
        }

        $dados = $this->relation->listarPorProduto($produto_id);
        if ($dados){
            echo json_encode(['status' => 'success', 'data' => $dados]);
        }
        else {
            echo json_encode(['status' => 'error', 'message' => 'Relacoes não encontrado']);
        }
    }

 
    public function excluir() {
    $id = 0;

   
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
    }

    if (!$id) {
        parse_str(file_get_contents("php://input"), $data);
        $id = intval($data['id'] ?? 0);
    }

    if (!$id) {
        echo "ID inválido.";
        return;
    }

    if ($this->relation->excluir($id)) {
        echo "Relação removida com sucesso!";
    } else {
        echo "Erro ao remover vínculo.";
    }
}


 
    public function removerEmMassa() {
    $ids = $_POST['ids'] ?? [];

    if (!is_array($ids) || empty($ids)) {
        echo "Nenhum vínculo selecionado.";
        return;
    }

    $ids = array_map('intval', $ids);

    echo $this->relation->excluirVarios($ids)
        ? "Vínculos removidos com sucesso!"
        : "Erro ao remover vínculos.";
}



}

$controller = new ProdutoFornecedorController($conn);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $action = $_POST['action'] ?? '';

        if ($action === 'removerEmMassa' && isset($_POST['ids'])) {
            $controller->removerEmMassa();
        } elseif ($action === 'remover' && isset($_POST['id'])) {
            $controller->excluir();
        } else {
            $controller->cadastrar(); 
        }
        break;

    case 'DELETE':
        $controller->excluir();
        break;

    case 'GET':
        $controller->listarPorProduto();
        break;

    default:
        echo "Método inválido!";
        break;
}

