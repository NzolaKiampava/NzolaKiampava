<?php

//------------------------------------ CONEXAO ------------------------------
	
	try
	{
		
		$pdo = new PDO("mysql:dbname=crudpdo;host=localhost","root","");

	}
	catch(PDOException $e)
	{
		
		echo "ERRO com banco de dados: ".$e->getMessage();

	}
	catch(Exception $e)
	{
		
		echo "ERRO genérico: ".$e->getMessage();

	}
	


//------------------------------------ INSERT -------------------------------
/*
	//1 FORMA
		//inicio
	$res = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES(:n, :t, :e)");

			//FAZENDO A SUBSTITUICAO
	$res->bindValue(":n","Miriam");
	$res->bindValue(":t","000000000");
	$res->bindValue(":e","teste@gmail.com");
			
			//FAZENDO A EXECUÇÃO
	$res->execute();
		//FIM



	//2 FORMA
		//inicio
	$pdo->query("INSERT INTO pessoa(nome, telefone, email) VALUES('Nzola', '924598849', 'nzolakiampava@gmail.com')");
		//FIM

*/


//------------------------------------- UPDATE E DELETE --------------------------
/*
	//UPDATE

		//1 FORMA
	$cmd = $pdo->prepare("UPDATE pessoa SET email=:e WHERE id=:id");	
	$cmd->bindValue(":e", "miriam@yahoo.com");
	$cmd->bindValue(":id", 19);
	$cmd->execute();

		//2 FORMA
	$cmd=$pdo->query("UPDATE pessoa SET email='Kiampava@gmail.com' WHERE id='4'");
	$cmd->execute();

	//-------------------------------
	//DELETE

		//1 FORMA
	$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id=:id");
	$cmd->bindValue(":id", 22);
	$cmd->execute();
*/

	//------------------------------------- SELECT -----------------------------------

		//EXIBINDO A INFORMAÇÃO NA TELA
	/*$cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id=:id");
	$cmd->bindValue(":id",20);
	$cmd->execute();
	$resultado = $cmd->fetch(PDO::FETCH_ASSOC);

	/*echo "<pre>"; //TESTE
	print_r($resultado);
	echo "</pre>";*/
/*
	foreach($resultado as $key => $value)
	{
		echo $key.": ".$value."<br>";
	}*/

	
?>