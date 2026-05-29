<?php

require_once "Database.php";

class Usuario {
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function criarUsuario($nome, $email, $senha){
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash
        ]);
    }

    // Listar todos os usuários
    public function listarUsuarios() {
        $sql = "SELECT id, nome, email, criado_em FROM usuarios";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar um usuário pelo ID
    public function buscarUsuario($id) {
        $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar usuário
    public function atualizarUsuario($id, $nome, $email) {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'id' => $id
        ]);
    }

    // Excluir usuário
    public function excluirUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Validar credenciais de login
    public function validarLogin($email, $senha) {
        $sql = "SELECT id, nome, senha FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
}