<?php
session_start();
require '../../database.php';
require '../models/Fornecedor.php';
require '../utils/tratarNomes.php';

class FornecedorController {
    private $fornecedor;

    public function __construct($db) {
        $this->fornecedor = new Fornecedor($db);
    }
    
  
    public function listarFornecedores() {
        $fornecedores = $this->fornecedor->getAll();

        if (!empty($fornecedores)) {
            echo json_encode($fornecedores);
        } else {
            echo json_encode([]);
        }
    }


  
    public function cadastrarFornecedor() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $nometratado = tratarNome($_POST['nome'] ?? '');
        $cnpj = trim($_POST['cnpj'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $status = trim($_POST['status'] ?? '');

      
        if (!$nometratado || !$cnpj || !$email) {
            echo "Por favor, preencha todos os campos obrigatórios!";
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail inválido!";
            return;
        }

      
        if ($this->fornecedor->cadastrar($nometratado, $cnpj, $email, $telefone, $status)) {
            echo "Fornecedor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar fornecedor!";
        }
    }

 
    public function atualizarFornecedor() {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') return;

        parse_str(file_get_contents("php://input"), $data);

        $id = $data['fornecedor_id'] ?? null;
        $nometratado = tratarNome($data['nome'] ?? '');
        $cnpj = trim($data['cnpj'] ?? '');
        $email = trim($data['email'] ?? '');
        $telefone = trim($data['telefone'] ?? '');
        $status = trim($data['status'] ?? '');

        if (!$id || !$nometratado || !$cnpj || !$email) {
            echo "Dados insuficientes para atualizar fornecedor.";
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail inválido!";
            return;
        }

        if ($this->fornecedor->atualizar($id, $nometratado, $cnpj, $email, $telefone, $status)) {
            echo json_encode(['status' => 'success', 'message' => 'Fornecedor atualizado.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar fornecedor!']);
        }
    }


    public function excluirFornecedor() {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') return;

        parse_str(file_get_contents("php://input"), $data);

        $id = $data['delete_fornecedor'] ?? null;
        if (!$id) {
            echo "ID do fornecedor não fornecido.";
            return;
        }

        if ($this->fornecedor->excluir($id)) {
            echo "Fornecedor removido com sucesso!";
        } else {
            echo "Erro ao remover fornecedor!";
        }
    }
}


$controller = new FornecedorController($conn);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $controller->listarFornecedores();
        break;
    case 'POST':
        $controller->cadastrarFornecedor();
        break;
    case 'PUT':
        $controller->atualizarFornecedor();
        break;
    case 'DELETE':
        $controller->excluirFornecedor();
        break;
    default:
        echo "Método inválido!";
        break;
}
?>
