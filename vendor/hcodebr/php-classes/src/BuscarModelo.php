<?php 

namespace Hcode;

use \Hcode\DB\Sql;

class BuscarModelo{

	function buscar($codModelo){

		$sql = new Sql();
	
		$result = $sql->select("SELECT p.id_produto, p.cod_prod, p.nome_prod, p.disponivel, p.imagem_prod, c.nome_cor, t.nome_tamanho, p.id_prodpai
								FROM tb_produtos AS p 
								INNER JOIN tb_cores AS c 
								ON p.id_cor = c.id_cor 
								INNER JOIN tb_tamanhos AS t 
								ON p.id_tamanho = t.id_tamanho
								WHERE p.cod_prod = $codModelo
								GROUP BY p.id_cor");

		$filtrado = [];

		if(count($result) > 0){

			$filtrado = $result;

		} else {

			$result2 = $sql->select("SELECT p.id_produto, p.cod_prod, p.nome_prod, p.disponivel, p.imagem_prod, c.nome_cor, p.id_prodpai
									FROM tb_produtos AS p 
									INNER JOIN tb_cores AS c 
									ON p.id_cor = c.id_cor 
									WHERE p.cod_prod = $codModelo
									GROUP BY p.imagem_prod");

			$filtrado = $result2;
		}

		if(count($filtrado) == 0){

			$result3 = $sql->select("SELECT p.id_produto, p.cod_prod, p.nome_prod, p.disponivel, p.imagem_prod, t.nome_tamanho, p.id_prodpai
									FROM tb_produtos AS p 
									INNER JOIN tb_tamanhos AS t 
									ON p.id_tamanho = t.id_tamanho 
									WHERE p.cod_prod = $codModelo");

			$filtrado = $result3;
		}

		return $filtrado;
	}

	function buscarTamanho($cod){

		$sql = new Sql();

		$result = $sql->select("SELECT p.id_produto, p.cod_prod, p.nome_prod, p.disponivel, p.imagem_prod, t.nome_tamanho, p.id_prodpai
								FROM tb_produtos AS p 
								INNER JOIN tb_tamanhos AS t 
								ON p.id_tamanho = t.id_tamanho
								WHERE p.cod_prod = $cod
								group by p.id_tamanho");
		return $result;
	}

	function limparSessao(){

		unset($_SESSION['cod'],$_SESSION['codModelo'],$_SESSION['excluido'],$_SESSION['email'],$_SESSION['filtrado'],$_SESSION['indisponiveis'],$_SESSION['infoProd'],$_SESSION['infoProd2'],$_SESSION['disponiveis'],$_SESSION['tamanhosNovos'],$_SESSION['infoProd3'],$_SESSION['cores'],$_SESSION['email-tmp']);
	}

	function buscarModeloCont($cod, $cores, $tamanhos){

		$sql = new Sql();

		$info = [];

		if(count($cores) > 0 and count($tamanhos) > 0){

			foreach($cores as $value){

				$cor = $value;

				$result = $sql->select("SELECT p.id_produto, p.cod_prod, c.nome_cor, t.nome_tamanho
									  FROM tb_produtos as p
									  INNER JOIN tb_cores as c
									  ON p.id_cor = c.id_cor
									  INNER JOIN tb_tamanhos as t
									  ON p.id_tamanho = t.id_tamanho
									  WHERE p.cod_prod = $cod
									  AND c.nome_cor = '$cor'");

					if(count($result) > 0){

						array_push($info, $result);

					} else {

						for ($i=0; $i<count($tamanhos); $i++) { 
							
							$corNova = array(
								'id_produto'=>NULL,
								'cod_prod'=>$cod,
								'nome_cor'=>$cor,
								'nome_tamanho'=>$tamanhos[$i],
								'cor_nova'=>1
								);

							array_push($info[0], $corNova);
					}		
				}
			}

			foreach ($tamanhos as $value){
				
				$tamanho = $value;

				$result = $sql->select("SELECT p.id_produto, p.cod_prod, c.nome_cor, t.nome_tamanho
									  FROM tb_produtos as p
									  INNER JOIN tb_cores as c
									  ON p.id_cor = c.id_cor
									  INNER JOIN tb_tamanhos as t
									  ON p.id_tamanho = t.id_tamanho
									  WHERE p.cod_prod = $cod
									  AND t.nome_tamanho = '$tamanho'");

				if(count($result) == 0){

					for ($i=0; $i<count($cores); $i++) { 
							
							$tamanhoNovo = array(
								'id_produto'=>NULL,
								'cod_prod'=>$cod,
								'nome_cor'=>$cores[$i],
								'nome_tamanho'=>$tamanho,
								'tamanho_novo'=>1
								);

							array_push($info[0], $tamanhoNovo);
					}
				}
			}
		} else if (count($tamanhos) > 0){

			foreach($tamanhos as $value){

				$tamanho = $value;

				$result = $sql->select("SELECT p.id_produto, p.cod_prod, t.nome_tamanho
									  FROM tb_produtos as p
									  INNER JOIN tb_tamanhos as t
									  ON p.id_tamanho = t.id_tamanho
									  WHERE p.cod_prod = $cod
									  AND t.nome_tamanho = '$tamanho'");

				if(count($result) > 0){

					array_push($info, $result);
				} else {

					$novo = array(
								'id_produto'=>NULL,
								'cod_prod'=>$cod,
								'nome_tamanho'=>$tamanho,
								'tamanho_novo'=>1
								);

					array_push($info[0], $novo);	
				}				
			}
		} else {

			foreach($cores as $value){

				$cor = $value;

				$result = $sql->select("SELECT p.id_produto, p.cod_prod, c.nome_cor
									  FROM tb_produtos as p
									  INNER JOIN tb_cores as c
									  ON p.id_cor = c.id_cor
									  WHERE p.cod_prod = $cod
									  AND c.nome_cor = '$cor'");

				if(count($result) > 0){

					array_push($info, $result);
				
				} else {

					$novo = array(
								'id_produto'=>NULL,
								'cod_prod'=>$cod,
								'nome_cor'=>$cor,
								);

					array_push($info[0], $novo);	
				}
			}
		}

		return $info;
	}

	function pegarIdProdutos($tamanhos, $cores, $idContagem){

		$sql = new Sql();

		$ids = [];
		
		foreach($cores as $cor){

			foreach ($tamanhos as $tamanho) {
				
				$idProd = $sql->select("SELECT id_produto FROM tb_contsub
									WHERE cor_prod = '$cor'
									AND tamanho_prod = '$tamanho'
									AND id_contagem = $idContagem");

				array_push($ids, $idProd);
			}
		}

		return $ids;
	}		
}	

?>