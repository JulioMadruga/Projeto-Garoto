<?php

class Usuario {
    private $id = null;
    private $nome = null;
    private $email = null;
    private $senha = null;
    private $tipo = null;
    
    public function getId() {
        return $this->id;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getTipo() {
        return $this->senha;
    }
    
    public function getSenha() {
        return $this->tipo;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    public function setTipo($tipo) {
        $this->senha = $tipo;
    }
}

