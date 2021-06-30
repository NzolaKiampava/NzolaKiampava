<?php

Class Pessoa
{
	private $pdo; //ARMAZENA TODAS AS INFORMAÇÕES DE CONEXAO

	//CONEXÃO COM BANCO DE DADOS
	public function __construct($dbname, $host, $user, $senha)
	{	
		try{

			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);

		}
		catch(PDOException $e){
			echo "ERRO COM A BASE DE DADOS: ".$e->getMessage();
			exit(); //PARE O RESTANTE DO CODIGO
		}
		catch(Exception $e){
			echo "ERRO: ".$e->getMessage();
			exit(); //PARE O RESTANTE DO CODIGO
		}
		
	}

	//BUSCANDO TODOS OS DADOS DO BANCO DE DADOS E COLOCAR NO CANTO DIREITO DA TELA
	public function buscarDados()
	{
		$res = array();//FOI UTILIZADO CASO O BANCO DE DADOS ESTIVER VAZIO ELE NAO VAI GERAR ERRO, SENOD ASSIM VAI RETORNAR UM ARRAY TAMBEM VAZIO
		$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
		$cmd->execute();
		$res = $cmd->fetchAll(PDO::FETCH_ASSOC);

		return $res;

	}

	//Funcao cadastrar pessoa no banco de dados
	public function cadastrarPessoa($nome, $telefone, $email)
	{
		//ANTES DE CADASTRAR VERIFICAR SE JA TEM EMAIL CADASTRADO
		$cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();

		if ($cmd->rowCount() > 0) //email já existe no banco de dados...isto é caso email ja esta cadastrado vai retornar falso
		{ 
			return false;
		}else //email nao foi encontrado.... sendo assim vamos inserir os dados da pessoa
		{
			$cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) values(:n,:t,:e)");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":t", $telefone);
			$cmd->bindValue(":e", $email);
			$cmd->execute();

			return true;
		}
	}

	//FUNCAO EXCLUIR PESSOA
	public function excluirPessoa($id)
	{
		$cmd =$this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
	}


	//BUSCAR OD DADOS DE UMA PESSOA
	public function buscarDadosPessoa($id)
	{	
		$res = array();
		$cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();

		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res;
	}


	//ATUALIZAR DADOS NO BANCO DE DADOS
	public function atualizarDados($id, $nome, $telefone, $email)
	{
		$cmd = $this->pdo->prepare("UPDATE pessoa SET nome=:n, telefone=:t, email=:e WHERE id=:id");
		$cmd->bindValue(":n", $nome);
		$cmd->bindValue(":t", $telefone);
		$cmd->bindValue(":e", $email);
		$cmd->bindValue(":id", $id);
		$cmd->execute();
	}



}


?>