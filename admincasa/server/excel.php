<?php
//inclui a conexao com o banco
include("conecta.php");

// Escolher o formato do arquivo
header("Content-type: application/msexcel");

// Nome que arquivo será salvo
header("Content-Disposition: attachment; filename=planilha_clientes.xls");

// Criar a tabela para receber os dados
echo "<table>";
 echo "<tr>";
	echo "<td>ID</td>";
	echo "<td>NOME</td>";
	echo "<td>SOBRENOME</td>";
	echo "<td>OBS</td>";
	echo "<td>DATA DE NASCIMENTO</td>";
	echo "<td>TELEFONE</td>";
	echo "<td>CELULAR</td>";
	echo "<td>RAMAL</td>";
	echo "<td>CIDADE</td>";
	echo "<td>BAIRRO</td>";
	echo "<td>RUA</td>";
	echo "<td>NUMERO</td>";
	echo "<td>COMPLEMENTO</td>";
	echo "<td>EMPRESA</td>";
	echo "<td>DEPARTAMENTO</td>";
	echo "<td>CPF</td>";
	echo "<td>EMAIL</td>";
	echo "<td>MENU</td>";
	echo "<td>PLANO</td>";
	echo "<td>PERIODO</td>";
	echo "<td>DATA DE PAGAMENTO</td>";
	echo "<td>FORMA DE PAGAMENTO</td>";
	echo "<td>EMBALAGEM</td>";
	echo "<td>DATA DE CADASTRO</td>";

	$query = mysql_query("SELECT * FROM tipo");
	while ($tipos = mysql_fetch_array($query)) {
		$id_tipo = $tipos['id'];

		$dnv = mysql_query("SELECT * FROM produto WHERE id_tipo = '$id_tipo'");
		while ($produtos = mysql_fetch_array($dnv)) {
			echo "<td>".utf8_decode($produtos['nome'])."</td>";
		}
	}
 echo "</tr>";

// Procurar as informações do BD
$SQL = "SELECT * FROM user WHERE ativo = 1 ORDER BY id DESC" ;
$executa = mysql_query($SQL);

while ($pegou = mysql_fetch_array($executa)){
	$id_cliente = $pegou['id'];

 if ($pegou['id_periodo'] == 1) {
	  $periodo = "Manhã";
	}elseif ($pegou['id_periodo'] == 2) {
	  $periodo = "Tarde";
	}else{
	  $periodo = "Não definido";
	}

	if ($pegou['id_plano'] == 1) {
	  $plano = "Quinzenal";
	}elseif ($pegou['id_periodo'] == 2) {
	  $plano = "Mensal";
	}else{
	  $plano = "Não definido";
	}

	if ($pegou['tipo_embalagem'] == 1) {
	  $embalagem = "Retornável";
	}elseif ($pegou['tipo_embalagem'] == 2) {
	  $embalagem = "Reciclável";
	}else{
	  $embalagem = "Não definido";
	}

	if (empty($pegou['complemento'])) {
		$complemento = "Não definido";
	}else{
		$complemento = $pegou['complemento'];
	}


	if ($pegou['forma_pagamento'] == 1) {
	  $pagamento = "Transferência (DOC)";
	}elseif ($pegou['forma_pagamento'] == 2) {
	  $pagamento = "PagSeguro";
	}elseif ($pegou['forma_pagamento'] == 3) {
	  $pagamento = "Moderninha";
	}else{
	  $pagamento = "Não definido"; }
 
 echo "<tr>";
		echo "<td>".$id_cliente."</td>";
		echo "<td>".utf8_decode($pegou['nome'])."</td>";
		echo "<td>".utf8_decode($pegou['sobrenome'])."</td>";
		echo "<td>".utf8_decode($pegou['observ'])."</td>";
		echo "<td>".$pegou['nascimento']."</td>";
		echo "<td>".$pegou['telefone']."</td>";
		echo "<td>".$pegou['celular']."</td>";
		echo "<td>".$pegou['ramal']."</td>";
		echo "<td>".utf8_decode($pegou['cidade'])."</td>";
		echo "<td>".utf8_decode($pegou['bairro'])."</td>";
		echo "<td>".utf8_decode($pegou['rua'])."</td>";
		echo "<td>".$pegou['numero']."</td>";
		echo "<td>".utf8_decode($complemento)."</td>";
		echo "<td>".utf8_decode($pegou['empresa'])."</td>";
		echo "<td>".utf8_decode($pegou['departamento'])."</td>";
		echo "<td>".$pegou['cpf']."</td>";
		echo "<td>".$pegou['email']."</td>";
		echo "<td>".$pegou['id_menu']."</td>";
		echo "<td>".utf8_decode($plano)."</td>";
		echo "<td>".utf8_decode($periodo)."</td>";
		echo "<td>".$pegou['data_pagamento']."</td>";
		echo "<td>".utf8_decode($pagamento)."</td>";
		echo "<td>".utf8_decode($embalagem)."</td>";
		echo "<td>".$pegou['data_cadastro']."</td>";

		$query = mysql_query("SELECT * FROM tipo");
		while ($tipos = mysql_fetch_array($query)) {
			$id_tipo = $tipos['id'];

			$dnv = mysql_query("SELECT * FROM produto WHERE id_tipo = '$id_tipo'");
			while ($produtos = mysql_fetch_array($dnv)) {
				$id_produto = $produtos['id'];
				$vamo = mysql_query("SELECT * FROM favorito WHERE id_user = '$id_cliente' AND id_produto = '$id_produto'");
				$favoritos = mysql_fetch_array($vamo);
				if (mysql_num_rows($vamo) == 0){
					echo "<td></td>";
				}else{
					echo "<td align='center'>S</td>";
				}
			}
		}

 echo "</tr>";
}
echo "</table>"; 
?>