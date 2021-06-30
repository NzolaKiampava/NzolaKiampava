<?php 
	require_once("classe-pessoa.php");

	//instanciando a classe pessoa
	$p = new Pessoa("crudpdo","localhost","root","");
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<?php
		if (isset($_POST['nome'])) 
		{ //SE EXISTE O ARRAY_POST ou se a pessoa clicar no botao cadastrar ou atualizaR

			//--------------------------------- EDITAR -------------------------
			if(isset($_GET['id_up']) && !empty($_GET['id_up']))
			{	
				$id_upd   = addslashes($_GET['id_up']);
				$nome     = addslashes($_POST['nome']);
				$telefone = addslashes($_POST['telefone']);
				$email    = addslashes($_POST['email']);

				if (!empty($nome) && !empty($telefone) && !empty($email)) 
				{ //se nao estiver vazio as variaveis nomes, telefones e email eniar na funcao cadastrar

					//ATUALIZAR
					$p->atualizarDados($id_upd, $nome, $telefone, $email);
					header("location: index.php"); //ATUALIZAR A PAGINA
					
				}else //caso contrario
				{
					?>	
					<div class="aviso">
						<img src="_img/aviso.jpg">
						<h4>Preencha todos os campos!</h4>
					</div>
					<?php
				}
				
			}

			//---------------------------------- CADASTRAR ---------------------
			else
			{
				/*para colher essas informações é com $Global_POST[], mas nunca podemos pegar informações directamente e guardar ela, isso gera uma falta de segurança, para isso utilizamos a funcao addslashes(), faz a proteccao para nao vir codigo malicioso q uma pessoa tente digitar nas caixinhas*/
				$nome = addslashes($_POST['nome']);
				$telefone = addslashes($_POST['telefone']);
				$email = addslashes($_POST['email']);

				if (!empty($nome) && !empty($telefone) && !empty($email)) { //se nao estiver vazio as variaveis nomes, telefones e email eniar na funcao cadastrar

					//cadastrar
					if (!$p->cadastrarPessoa($nome, $telefone, $email)) { //se o retorno for falso
						
						?>	
						<div class="aviso">
							<img src="_img/aviso.jpg">
							<h4>Email já está cadastrado!</h4>
						</div>
						<?php
					}

					/*ou if($p->cadastrarPessoa($nome, $telefone, $email))
					{

					}else
					{
						echo "Email já está cadastrado";
					}*/
					
				}else //caso contrario
				{
					?>	
					<div class="aviso">
						<img src="_img/aviso.jpg">
						<h4>Preencha todos os campos!</h4>
					</div>
					<?php
				}
			}

		}

	?>

	<?php

		if(isset($_GET['id_up'])) //se a pessoa clicou em editar
		{
			$id_update = addslashes($_GET['id_up']);
			$res = $p->buscarDadosPessoa($id_update);

		}


	?>

	<section id="esquerda">
		<form method="POST">
			<h2>CADASTRAR PESSOA</h2>
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome"
			value="<?php if(isset($res)){ echo $res['nome'];}?>">
			<label for="tel">Telefone</label>
			<input type="text" name="telefone" id="tel" 
			value="<?php if(isset($res)){ echo $res['telefone'];}?>">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" 
			value="<?php if(isset($res)){ echo $res['email'];}?>">

			<input type="submit" 
			value="<?php if(isset($res)){echo'ACTUALIZAR';}else{echo'CADASTRAR';}?>">
		</form>
	</section>

	<section id="direita">

		<table>
			<tr id="titulo">
				<td>NOME</td>
				<td>TELEFONE</td>
				<td colspan="2">EMAIL</td>
			</tr>

		<?php
			$dados = $p->buscarDados();
			
			if (count($dados) > 0) 
			{ //EM CASO SE NOA TIVER VAZIO O BANCO ou se tem pessoa cadastrado
				for ($i=0; $i < count($dados) ; $i++) { 
					echo "<tr>";
					foreach ($dados[$i] as $k => $v) {

						if ($k != "id") { //APENAS ENTRAR NESSE BLOCO SE NAO FOR A COLUNA ID
							echo"<td>".$v."</td>";
						}	
					}
					?>

				<td>
					<a class="editar" href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
					<a class="excluir" href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
				</td>

					<?php
					echo "</tr>";
				}
			}else //o banco de dados esta vazio
			{	

			?>
		?>
		</table>
		?>
			<div class="aviso">
				<h4>Ainda não há pessoa cadastradas!</h4>
			</div>
			<?php
		}
		?>
	</section>

</body>
</html>
<?php
	
	//ver se existe 	
	if(isset($_GET['id']))
	{
		$id_pessoa = addslashes($_GET['id']);
		$p->excluirPessoa($id_pessoa);
		header("location: index.php"); //ATUALIZAR A PAGINA
	}
	
?>