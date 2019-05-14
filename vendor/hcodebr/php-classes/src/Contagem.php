<?php 

namespace Hcode;

use \Hcode\DB\Sql;

class Contagem{

	function inserirContagem($produtos, $user){

	 	$sql = new Sql();
		
		$data = date("Y/m/d");
		$hora = date("H:i:s");
		$userId = $user['id_usuario'];

 		$sql->query("INSERT INTO tb_contagens VALUES(:IDCONTAGEM,:CODMODELO,:DATACONT,:HORAI,:HORAF,:IDADM,:IDCONT1,:IDCONT2,:STATUS)", array(
 			':IDCONTAGEM'=>NULL,
 			':CODMODELO'=>$produtos[0][0]['cod_prod'],
 			':DATACONT'=>$data,
 			':HORAI'=>$hora,
 			':HORAF'=>NULL,
 			':IDADM'=>$userId,
 			':IDCONT1'=>NULL,
 			':IDCONT2'=>NULL,
 			':STATUS'=>1
 			));

 		if($sql){

 			$lastInsertId = $sql->select("SELECT LAST_INSERT_ID()");

 			$idContagem = $lastInsertId[0]['LAST_INSERT_ID()'];

 			for ($i=0; $i<count($produtos); $i++){ 
 			
	 			foreach ($produtos[$i] as $value){

	 				if(isset($value['id_produto'])){

	 					$idProduto = $value['id_produto'];
	 				} else {

	 					$idProduto = 0;
	 				}
					
					if(isset($value['cor_nova'])){

		 					$corNova = 1;
		 			} else { 

		 					$corNova = 0;
		 			}

		 			if(isset($value['tamanho_novo'])){

		 					$tamanhoNovo = 1;
		 			} else {

		 					$tamanhoNovo = 0;
		 			}

		 			if(isset($value['nome_tamanho'])){

		 				$nomeTamanho = $value['nome_tamanho'];
		 			} else {

		 				$nomeTamanho = NULL;
		 			}

		 			if(isset($value['nome_cor'])){

		 				$nomeCor = $value['nome_cor'];
		 			} else {

		 				$nomeCor = NULL;
		 			}

		 			$sql->query("INSERT INTO tb_contsub(id_contsub,id_contagem,id_produto,tamanho_prod,cor_prod,cor_nova,tamanho_novo)
		 						 VALUES(:IDCONTSUB,:IDCONTAGEM,:IDPROD,:TAMANHO,:COR,:CORNOVA,:TAMANHONOVO)", array(
																							 				':IDCONTSUB'=>NULL,
																							 				':IDCONTAGEM'=>$lastInsertId[0]['LAST_INSERT_ID()'],
																							 				':IDPROD'=>$idProduto,
																							 				':TAMANHO'=>$nomeTamanho,
																							 				':COR'=>$nomeCor,
																							 				':CORNOVA'=>$corNova,
																							 				':TAMANHONOVO'=>$tamanhoNovo						));
				}
			}
		
 		} else {

 			echo "Erro ao criar contagem! D:";
 		}

 		return $idContagem;
	}

	function buscarDados($idContagem){

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_contsub WHERE id_contagem = $idContagem");

		return $result;
	}

	function montarTH($dados){

		$array = [];

		foreach ($dados as $value){

			if (isset($value['tamanho_prod'])) {
				
				$tamanho = $value['tamanho_prod'];
			} else {

				$tamanho = "X";
			}

			array_push($array, $tamanho);
		}

		$arrayUnique = array_unique($array);

		return $arrayUnique;	
	}

	function montarTD($dados,$cod){

		$array = [];

		foreach ($dados as $value){

			if(isset($value['cor_prod'])){

				$cor = $value['cor_prod'];	

				array_push($array, $cor);

			} else {

				$cor = 'X';

				array_push($array, $cor);
			}
		}

		$arrayUnique = array_unique($array);

		return $arrayUnique;
	}

	function montarArray($cores, $tamanhos, $idContagem){

		$info = [];

		$sql = new Sql();

		if(count($cores) > 0 and $cores[0] !='X' and count($tamanhos) > 0 and $tamanhos[0] !='X'){

			foreach($cores as $cor){

				foreach($tamanhos as $tamanho){

					$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
											   WHERE cor_prod = '$cor'
											   AND  tamanho_prod = '$tamanho'
											   AND id_contagem = $idContagem");

					$valores = array(
							   "cor"=>$cor,
							   "tamanho"=>$tamanho,
							   "id"=>$idProduto[0]['id_produto']);

					array_push($info, $valores);				
				}
			}
		} else if(count($tamanhos) > 0 and $tamanhos[0] !='X'){

			foreach($tamanhos as $tamanho){

				$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
										   WHERE tamanho_prod = '$tamanho'
										   AND id_contagem = $idContagem");

				$valores = array(
							"tamanho"=>$tamanho,
							"id"=>$idProduto[0]['id_produto']);

				array_push($info, $valores);
			}
		} else {

			foreach($cores as $cor){

				$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
										   WHERE cor_prod = '$cor'
										   AND id_contagem = $idContagem");

				$valores = array(
							"cor"=>$cor,
							"id"=>$idProduto[0]['id_produto']);

				array_push($info, $valores);

			}			
		}

		return $info;
	}

	function buscarContagens(){

		$sql = new Sql();

		$result = $sql->select("SELECT c.id_contagem, c.cod_modelo, DATE_FORMAT(c.data_cont, '%d/%m/%Y') as data_cont, c.hora_inicio, c.hora_fim, c.id_cont1, c.id_cont2, u.nome_usuario, s.desc_status
								FROM tb_contagens as c
								INNER JOIN tb_status_contagem as s
								ON s.id_status = c.status_contagem
                                INNER JOIN tb_usuarios as u
                                ON c.id_adm = u.id_usuario
                                WHERE c.status_contagem != 4
                                AND c.status_contagem != 7
                                AND c.status_contagem != 8
                                ORDER BY s.desc_status");

		return $result;
	}

	function buscarContagensFinalizadas(){

		$sql = new Sql();

		$result = $sql->select("SELECT c.id_contagem, c.cod_modelo, DATE_FORMAT(c.data_cont, '%d/%m/%Y') as data_cont, c.hora_inicio, c.hora_fim, c.id_cont1, c.id_cont2, u.nome_usuario, s.desc_status
								FROM tb_contagens as c
								INNER JOIN tb_status_contagem as s
								ON s.id_status = c.status_contagem
                                INNER JOIN tb_usuarios as u
                                ON c.id_adm = u.id_usuario
                                WHERE c.status_contagem = 4
                                ORDER BY c.id_contagem DESC");

		return $result;
	}

	function buscarContagensTratamento(){

		$sql = new Sql();

		$result = $sql->select("SELECT c.id_contagem, c.cod_modelo, DATE_FORMAT(c.data_cont, '%d/%m/%Y') as data_cont, c.hora_inicio, c.hora_fim, c.id_cont1, c.id_cont2, u.nome_usuario, s.desc_status
								FROM tb_contagens as c
								INNER JOIN tb_status_contagem as s
								ON s.id_status = c.status_contagem
                                INNER JOIN tb_usuarios as u
                                ON c.id_adm = u.id_usuario
                                WHERE c.status_contagem = 6
                                OR c.status_contagem = 8
                                OR c.status_contagem = 7
                                ORDER BY s.desc_status");

		return $result;
	}

	function ordenarArray($array){

		$ordem = ["PREMATURO","3535","RN","P","M","G","1","2","3","4","6","14-15","15-17","16-19","20-23","24-27","14","15","16","17","18","17-18","19","20","21","20-21","22","23","22-23","24","23-24","25","24-25"];

		$ordenado = array_merge(
					array_intersect($ordem, $array),
					array_diff($array, $ordem));

		return $ordenado;
	}

	function buscarId($tabela,$idContagem){

		$sql = new Sql();

		$id = [];

		foreach ($tabela as $value){

			$cor = $value['cor'];

			unset($value['cor']);

			foreach ($value as $chave => $valor){

				if(isset($cor) and $cor != 'X'){

					$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
										   	   WHERE cor_prod = '$cor'
										   	   AND tamanho_prod = '$chave'
										   	   AND id_contagem = $idContagem");

					if(count($idProduto) == 0){

						$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
											   	   WHERE cor_prod = '$cor'
											   	   AND id_contagem = $idContagem");
					}

					$id_valores = array(
								"idProduto"=>$idProduto,
								"qtd"=>$valor);

					array_push($id, $id_valores);

				} else {

					$idProduto = $sql->select("SELECT id_produto FROM tb_contsub
											   WHERE tamanho_prod = '$chave'
											   AND id_contagem = $idContagem");

					$id_valores = array(
									"idProduto"=>$idProduto,
									"qtd"=>$valor);

					array_push($id, $id_valores);
				}
			}
		}

		return $id;
	}

	function salvarContagem($idProds, $idContagem, $idCont){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_contsub WHERE id_contagem = $idContagem");

		$hora = date('H:i:s');

		foreach($idProds as $value){

			$qtd = $value['qtd'];
		
			$id = $value['idProduto'][0]['id_produto'];

			if(is_null($results[0]['id_cont1'])){

				$sql->query("UPDATE tb_contsub
							 SET id_cont1 = $idCont, hora_registro_cont1 = '$hora', qtde_cont1 = $qtd
							 WHERE id_contagem = $idContagem 
							 AND id_produto = $id");

				$sql->query("UPDATE tb_contagens
							 SET id_cont1 = $idCont
							 WHERE id_contagem = $idContagem");

			} else{

				$sql->query("UPDATE tb_contsub
							 SET id_cont2 = $idCont, hora_registro_cont2 = '$hora', qtde_cont2 = $qtd
							 WHERE id_contagem = $idContagem
							 AND id_produto = $id");

				$sql->query("UPDATE tb_contagens
							 SET status_contagem = 5, id_cont2 = $idCont, hora_fim = '$hora'
							 WHERE id_contagem = $idContagem");
			}
		} 
	}

	function salvarRecontagem($idProds, $idContagem){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_contsub WHERE id_contagem = $idContagem");

		$hora = date('H:i:s');

		foreach($idProds as $value){

			$id = $value['idProduto'][0]['id_produto'];

			$qtd = $value['qtd'];

			$sql->query("UPDATE tb_contsub
						 SET qtde_correta = $qtd
						 WHERE id_contagem = $idContagem
						 AND id_produto = $id");
		}
	}

	function excluirContagem($idContagem){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_contsub WHERE id_contagem = $idContagem");

		if($sql){

			$sql->query("DELETE FROM tb_contagens WHERE id_contagem = $idContagem");
		}
	}

	function verificarContagem($idContagem){

		$sql = new Sql();

		$status = 0;

		$results = $sql->select("SELECT id_produto, qtde_cont1, qtde_cont2, cor_nova, tamanho_novo, qtde_correta FROM tb_contsub WHERE id_contagem = $idContagem");

		foreach($results as $value){

			$id = $value['id_produto'];

			$qtde = $value['qtde_cont1'];

			$disponivel = $sql->select("SELECT disponivel FROM tb_produtos WHERE id_produto = $id");

			if($value['qtde_correta'] == ""){

				if($value['qtde_cont1'] != $value['qtde_cont2']){

					$status = 2;
					break;
				}	
			} 

			if($value['cor_nova'] == 1 or $value['tamanho_novo'] == 1){

				$status = 8;
				break;
			}

			if($disponivel[0]['disponivel'] == 0){

				$status = 7;
				break;
			}
		}

		if($status == 0){

			$status = 3;
		}

		if($status != 2){

			foreach ($results as $value){

			$id = $value['id_produto'];

			$qtde = $value['qtde_cont1'];

			$sql->query("UPDATE tb_contsub 
						 SET qtde_correta = $qtde
						 WHERE id_contagem = $idContagem
						 AND id_produto = $id");
			}
		}

		//Atualiza o status da tabela 
		$sql->query("UPDATE tb_contagens 
					 SET status_contagem = $status
					 WHERE id_contagem = $idContagem");
	}

	function buscarVariacao($idProduto){

		$sql = new Sql();

		$tamanho = $sql->select("SELECT t.nome_tamanho FROM tb_produtos AS p
								 INNER JOIN tb_tamanhos AS t
								 ON p.id_tamanho = t.id_tamanho
								 WHERE p.id_produto = $idProduto");

		$cor = $sql->select("SELECT c.nome_cor FROM tb_produtos AS p
							 INNER JOIN tb_cores AS c
							 ON p.id_cor = c.id_cor
							 WHERE p.id_produto = $idProduto");


		if(isset($tamanho[0]['nome_tamanho']) and isset($cor[0]['nome_cor'])){

			$nomeVariacao = "Tamanho: " . $tamanho[0]['nome_tamanho'] . " | Cor: " . $cor[0]['nome_cor'];
		
		} else if(isset($tamanho[0]['nome_tamanho']) and !isset($cor[0]['nome_cor'])){

			$nomeVariacao = "Tamanho: " . $tamanho[0]['nome_tamanho']; 

		} else {

			$nomeVariacao = "Cor: " . $cor[0]['nome_cor'];
		}

		return $nomeVariacao;
	}

	function gerarExcel(){

		$sql = new Sql();

		$info = [];
		$cods = [];

		if(count($_POST) > 0){

			foreach($_POST as $key => $val){

				$result = $sql->select("SELECT * FROM tb_contsub 
										WHERE id_contagem = $key
										AND qtde_correta != 0 
										ORDER BY id_produto");

				array_push($info, $result);	
			}

		} else {

			echo "Nenhuma contagem selecionada!";
			exit;
		}

		foreach($info as $value){

			foreach($value as $val){

				$idProduto = $val['id_produto'];
				$idContagem = $val['id_contagem'];

				$idOtixPai = $sql->select("SELECT id_otix_pai FROM tb_produtos_otix WHERE id_fast = $idProduto");
				$idOtixSub = $sql->select("SELECT id_otix_sub FROM tb_produtos_otix WHERE id_fast = $idProduto");
				$cod = $sql->select("SELECT cod_modelo FROM tb_contagens WHERE id_contagem = $idContagem");
				$qtd = $sql->select("SELECT qtde_correta FROM tb_contsub WHERE id_contagem = $idContagem AND id_produto = $idProduto");
				$nomeProd = $sql->select("SELECT nome_prod FROM tb_produtos WHERE id_produto = $idProduto");

				$nomeVariacao = $this->buscarVariacao($idProduto);

				$id = array(
							'id_otix_pai'=>$idOtixPai[0]['id_otix_pai'],
							'id_otix_sub'=>$idOtixSub[0]['id_otix_sub'],
							'cod_modelo'=>$cod[0]['cod_modelo'],
							'qtde_correta'=>$qtd[0]['qtde_correta'],
							'nome_prod'=>$nomeProd[0]['nome_prod'],
							'nome_var'=>$nomeVariacao);

				array_push($cods, $id);
			}	
		}

		$infoFinal = [];

		$z = 0;

		for($i=0; $i<count($cods); $i++){

			$dados = array(
					 'IDPRODUTO'=>$cods[$i]['id_otix_pai'],
					 'ID'=>$cods[$i]['id_otix_sub'],
					 'QUANTIDADE'=>$cods[$i]['qtde_correta'],
					 'CODIGOMODELO'=>$cods[$i]['cod_modelo'],
					 'NOMEPROD'=>$cods[$i]['nome_prod'],
					 'VARIACAO_NOME'=>$cods[$i]['nome_var']);

			array_push($infoFinal, $dados);	
		}

		$data = date("d-m-Y");

		$arquivo = "subirEstoque-" . $data . ".xls";

		$html = '';
		$html .= "<table border=1 cellspacing=0 cellpadding=2 style='white-space:nowrap;'>";

		//Headers da planilha
		$html .= "<tr>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>IDPRODUTO</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>CODIGOMODELO</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>NOME</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>ID</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>VARIACAO_NOME</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>QUANTIDADE</center></b></td>";
		$html .= "<td bgcolor='#C0C0C0'><b><center>VALOR</center></b></td>";
		$html .= "</tr>";
		
		foreach($infoFinal as $value){

			$idProd = $value['IDPRODUTO'];
			$id = $value['ID'];
			$qtd = $value['QUANTIDADE'];
			$valor = 1;
			$codModelo = $value['CODIGOMODELO'];
			$nomeProduto = utf8_decode($value['NOMEPROD']);
			$nomeVariacao = $value['VARIACAO_NOME'];

			$html .= "<tr>";
			$html .= "<td><center>$idProd</center></td>";
			$html .= "<td><center>$codModelo</center></td>";
			$html .= "<td><center>$nomeProduto</center></td>";
			$html .= "<td><center>$id</center></td>";
			$html .= "<td><center>$nomeVariacao</center></td>";
			$html .= "<td><center>$qtd</center></td>";
			$html .= "<td><center>$valor</center></td>";
			$html .= "</tr>";
		}

		$html .= '</table>';

		#foreach pra marcar a contagem como finalizada após gerar a planilha
		foreach($_POST as $key => $value){

			$sql->query("UPDATE tb_contagens
						 SET status_contagem = 4
						 WHERE id_contagem = $key");
		}

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: application/x-msexcel");
		header("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header("Content-Description: PHP Generated Data" );
		
		echo $html;
		exit;
	}

	function buscarDetalhes($idContagem,$cod){

		$sql = new Sql();

		$info = [];

		$idStatus = $sql->select("SELECT status_contagem FROM tb_contagens WHERE id_contagem = $idContagem");

		switch($idStatus[0]['status_contagem']){
			
			#Contagem de produto novo	
			case 6:
				
				break;

			#Contagem com produto inativo
			case 7:

				$result2 = $sql->select("SELECT c.nome_cor, t.nome_tamanho 
										 FROM tb_produtos as p
										 INNER JOIN tb_cores as c
										 ON p.id_cor = c.id_cor
										 INNER JOIN tb_tamanhos as t
										 ON p.id_tamanho = t.id_tamanho
										 WHERE cod_prod = $cod
										 AND disponivel = 0
										 ORDER BY p.id_produto");

				if(count($result2) == 0){

					$result2 = $sql->select("SELECT t.nome_tamanho 
											 FROM tb_produtos as p
											 INNER JOIN tb_tamanhos as t
											 ON p.id_tamanho = t.id_tamanho
											 WHERE cod_prod = $cod
											 AND disponivel = 0
											 ORDER BY p.id_produto");
				}

				if(count($result2) == 0){

					$result2 = $sql->select("SELECT c.nome_cor
											 FROM tb_produtos as p
											 INNER JOIN tb_cores as c
											 ON p.id_cor = c.id_cor
											 WHERE cod_prod = $cod
											 AND disponivel = 0
											 ORDER BY p.id_produto");
				}

				foreach($result2 as $value){

					$cor = "";
					$tamanho = "";

					if(isset($value['nome_cor'])){

						$cor = $value['nome_cor'];
					}

					if(isset($value['nome_tamanho'])){

						$tamanho = $value['nome_tamanho'];
					}

					if($cor != "" and $tamanho != ""){

						$detalhe = "Ativar a Cor: " . $cor . " Tamanho: " . $tamanho . " no produto: " . $cod;

					} elseif($tamanho != ""){

						$detalhe = "Ativar o tamanho: $tamanho no produto $cod";

					} else {

						$detalhe = "Ativar a cor: $cor no produto $cod";
					}

					array_push($info, $detalhe);
				}

				break;
			
			#Contagem com cor ou tamanho novo
			case 8:

				$corNova = "";
				$cor = "";
				$tamanhoNovo = "";
				$tamanho = "";

				$result = $sql->select("SELECT cor_prod, cor_nova FROM tb_contsub WHERE id_contagem = $idContagem ORDER BY cor_prod");

				foreach($result as $value){

					if(isset($value['cor_nova']) and $value['cor_nova'] != ""){

						$corNova = $value['cor_nova'];
						$cor = $value['cor_prod'];
					}
									
					if($corNova == 1){

						$detalhe = "Cadastrar a cor: $cor no produto: $cod";
						array_push($info, $detalhe);
					}
				}

				$result2 = $sql->select("SELECT tamanho_prod, tamanho_novo FROM tb_contsub WHERE id_contagem = $idContagem ORDER BY tamanho_prod");

				foreach($result2 as $value){

					if(isset($value['tamanho_novo']) and $value['tamanho_novo'] != ""){

						$tamanhoNovo = $value['tamanho_novo'];
						$tamanho = $value['tamanho_prod'];
					}
					
					if($tamanhoNovo == 1){

						$detalhe = "Cadastrar o tamanho: $tamanho no produto: $cod";
						array_push($info, $detalhe);
					}
				}
					
				break;
		}

		$info = array_unique($info);

		return $info;
	}

	function verContagemFinalizada($idContagem){

		$sql = new Sql();

		$results = $sql->select("SELECT c.id_contagem,c.tamanho_prod,c.cor_prod,u1.nome_usuario as nome_cont1,c.qtde_cont1,u2.nome_usuario as nome_cont2,c.qtde_cont2,c.qtde_correta
								 FROM tb_contsub c, tb_usuarios u1, tb_usuarios u2
								 WHERE u1.id_usuario = c.id_cont1 
								 AND u2.id_usuario = c.id_cont2 
								 AND c.id_contagem = $idContagem
								 ORDER BY c.id_produto");

		return $results;
	}
}
?>