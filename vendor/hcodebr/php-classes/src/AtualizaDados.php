<?php 

namespace Hcode;

use \Hcode\DB\Sql;

class AtualizaDados{

	public function inserirDadosFast($produtos){

		$sql = new Sql();

		$produtos2 = [];

		foreach ($produtos as $value){

			if($value["CorProd"] == ""){

				$value["CorProd"] = NULL;
			}

			if($value["Tamanho"] == ""){

				$value["Tamanho"] = NULL;
			}

			array_push($produtos2, $value);			
		}

		foreach($produtos2 as $value){

			$nome = utf8_decode($value['NomeProd']);

			$sql->query("INSERT INTO tb_produtos 
						 VALUES (:IDPRODUTO,:CODPROD,:NOMEPROD,:DISPONIVEL,:IMAGEM,:COR,:TAMANHO,:IDPRODUTOPAI)",
						array(
						':IDPRODUTO'=>$value['IDProduto'],
						':CODPROD'=>$value['CodProd'],
						':NOMEPROD'=>$nome,
						':DISPONIVEL'=>$value['Disponivel'],
						':IMAGEM'=>$value['ImagemProd'],
						':COR'=>$value['CorProd'],
						':TAMANHO'=>$value['Tamanho'],
						':IDPRODUTOPAI'=>$value['IDProdutoPai']
						));
		}
	}

	public function pegarValoresFast($string_campos,$campos,$url,$page){

		///temos que colocar os parâmetros do post no estilo de uma query string
		foreach($campos as $name => $valor) {
    		$string_campos .= $name . '=' . $valor . '&';
		}	
	
		$string_campos = rtrim($string_campos,'&');
		$string_campos .= "&Page=$page";
		
		//echo $string_campos;

		$ch = curl_init();

		//configurando as opções da conexão curl
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE); //este parâmetro diz que queremos resgatar o retorno da requisição
		curl_setopt($ch,CURLOPT_POST,count($campos));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);

		//manda a requisição post
		$resultado = curl_exec($ch);

		$resultado = utf8_encode($resultado);
		$obj = json_decode($resultado, true);

		$dados = $obj['data'];

		$registros_lidos = $obj['readRecords'];

		curl_close($ch);

		$info = array(
				'registros_lidos'=>$registros_lidos,
				'dados'=>$dados);
				
		return $info; 
	}

	public function atualizarDadosFast(){

		$x = 1000;

		$url = 'https://www.rumo.com.br/sistema/adm/APILogon.asp';

		$campos = array(
	   	'StoreName'=>urlencode("Bebe Fofuxo"),
		'StoreID'=>urlencode("20368"),
		'Username'=>urlencode("tecnologia"),
		'Password'=>urlencode("efrtec1234"),
		'Method'=>urlencode("ReportView"),
		'ObjectID'=>urlencode("425"),
		'OutputFormat'=>urlencode("6"),
		'Fields'=>urlencode("IDProduto,CodProd,NomeProd,Disponivel,ImagemProd,Cores,Adicional1,IDProdutoPai"),
		'QtRecords'=>urlencode("1000")
		);

		$string_campos = "";
		$page = 1;

		$formatado = [];

		while($x == 1000){
		
		$info = $this->pegarValoresFast($string_campos,$campos,$url,$page);

		$dados = $info['dados'];

		$x = $info['registros_lidos'];	

			foreach($dados as $value){

				$nomeProd = utf8_encode($value['2']);

				$tmp = array(
					'IDProduto'=>$value['0'],
					'CodProd'=>$value['1'],
					'NomeProd'=>$nomeProd,
					'Disponivel'=>$value['3'],
					'ImagemProd'=>$value['4'],
					'CorProd'=>$value['6'],
					'Tamanho'=>$value['5'],
					'IDProdutoPai'=>$value['7']
				);

					array_push($formatado, $tmp);
			}	
		
		$this->inserirDadosFast($formatado);
			
		$page++;

		}
	}

	public function pegarValoresOtix($page){

		$url = "http://sistema85.otixerp.com.br/app/otix/produto-variacao?page=$page";

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);

		$resultado = curl_exec($ch);

		$obj = json_decode($resultado, true);

		$registros_lidos = $obj['count'];

		$dados = $obj['_embedded']['produto_variacao'];

		curl_close($ch);

		$idOtixPai = [];
		$idOtixSub = [];
		$idFast = [];

		$idsOtix = [];

		foreach($dados as $value){

			$idPai = $value['_embedded']['produto']['id'];
			$idSub = $value['id'];
			$idFastSub = $value['lvId'];

			array_push($idOtixPai, $idPai);
			array_push($idOtixSub, $idSub);
			array_push($idFast, $idFastSub);
		}

		for ($i=0; $i<count($idOtixSub); $i++){ 
			
			$idsOtixValues = array(
							 'id_Otix_Pai'=>$idOtixPai[$i],
							 'id_Otix_Sub'=>$idOtixSub[$i],
							 'id_Fast'=>$idFast[$i]);

			array_push($idsOtix, $idsOtixValues);
		}

		$info = array(
				'idsOtix'=>$idsOtix,
				'registros_lidos'=>$registros_lidos,
				'url'=>$url
				);

		return $info;
	}

	public function inserirDadosOtix($dados){

		$sql = new Sql();

		$sql->query("INSERT INTO tb_produtos_otix VALUES(:IDOTIXPAI,:IDOTIXSUB,:IDFAST)",
			  array(
				 'IDOTIXPAI'=>$dados['id_Otix_Pai'],
				 'IDOTIXSUB'=>$dados['id_Otix_Sub'],
				 'IDFAST'=>$dados['id_Fast']));
		}

	public function atualizarDadosOtix(){

		$page = 1;

		$k = 25;

		while($k == 25){

			$info = $this->pegarValoresOtix($page);

			$idsOtix = $info['idsOtix'];

			$k = $info['registros_lidos'];

			foreach($idsOtix as $value){

				$this->inserirDadosOtix($value);
			}

            	$page++;
		}
	}

	public function atualizarCores($sql){

		$url = 'https://www.rumo.com.br/sistema/adm/APILogon.asp';

		$campos = array(
	   	'StoreName'=>urlencode("Bebe Fofuxo"),
		'StoreID'=>urlencode("20368"),
		'Username'=>urlencode("tecnologia"),
		'Password'=>urlencode("efrtec1234"),
		'Method'=>urlencode("ReportView"),
		'ObjectID'=>urlencode("394"),
		'OutputFormat'=>urlencode("6"),
		'QtRecords'=>urlencode("1000")
		);

		$string_campos = "";
		$page = 1;

		foreach($campos as $name => $valor) {
    		$string_campos .= $name . '=' . $valor . '&';
		}	
	
		$string_campos = rtrim($string_campos,'&');
		$string_campos .= "&Page=$page";

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_POST,count($campos));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);

		$resultado = curl_exec($ch);

		$resultado = utf8_encode($resultado);
		$obj = json_decode($resultado, true);

		$idCores = [];
		$nomeCores = [];

		$cores = [];

		$dados = $obj['data'];

		curl_close($ch);

		foreach($dados as $value){

			$idCor = $value['0'];
			$nomeCor = $value['1'];

			array_push($idCores, $idCor);
			array_push($nomeCores, $nomeCor);
		}

		for ($i=0; $i<count($idCores); $i++) { 
			
			$cores_tmp = array(
				 'IdCor'=>$idCores[$i],
				 'NomeCor'=>$nomeCores[$i]
				 );

			array_push($cores, $cores_tmp);
		}

		foreach ($cores as $value) {

		$sql->query("INSERT INTO tb_cores VALUES(:IDCOR,:NOMECOR)", 
				array(
				':IDCOR'=>$value['IdCor'],
				':NOMECOR'=>$value['NomeCor']));
		}		
	}

	public function atualizarTamanhos($sql){

		$url = 'https://www.rumo.com.br/sistema/adm/APILogon.asp';

		$campos = array(
	   	'StoreName'=>urlencode("Bebe Fofuxo"),
		'StoreID'=>urlencode("20368"),
		'Username'=>urlencode("tecnologia"),
		'Password'=>urlencode("efrtec1234"),
		'Method'=>urlencode("ReportView"),
		'ObjectID'=>urlencode("393"),
		'OutputFormat'=>urlencode("6"),
		'Par1'=>("0")
		);

		$string_campos = "";
		$page = 1;

		foreach($campos as $name => $valor) {
    		$string_campos .= $name . '=' . $valor . '&';
		}	
	
		$string_campos = rtrim($string_campos,'&');
		$string_campos .= "&Page=$page";

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_POST,count($campos));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);

		$resultado = curl_exec($ch);

		$resultado = utf8_encode($resultado);
		$obj = json_decode($resultado, true);

		$dados = $obj['data'];

		curl_close($ch);

		$idTamanhos = [];
		$nomeTamanhos = [];

		$tamanhos = [];

		foreach($dados as $value){

			$idTamanho = $value['0'];
			$nomeTamanho = $value['1'];

			array_push($idTamanhos, $idTamanho);
			array_push($nomeTamanhos, $nomeTamanho);
		}
		
		for ($i=0; $i<count($idTamanhos) ; $i++) { 
			
			$tamanhos_tmp = array(
							'id_tamanho'=>$idTamanhos[$i],
							'nome_tamanho'=>$nomeTamanhos[$i]
							);

			array_push($tamanhos, $tamanhos_tmp);
		}

		foreach($tamanhos as $value){

			$sql->query("INSERT INTO tb_tamanhos VALUES(:IDTAMANHO,:NOMETAMANHO)", array(
			':IDTAMANHO'=>$value['id_tamanho'],
			':NOMETAMANHO'=>$value['nome_tamanho']));
		}

	}

	public function deletarDadosFast($sql){

		$sql->query("DELETE FROM tb_produtos");
	}

	public function deletarDadosOtix($sql){

		$sql->query("DELETE FROM tb_produtos_otix");
	}

	public function deletarCores($sql){

		$sql->query("DELETE FROM tb_cores");
	}

	public function deletarTamanhos($sql){

		$sql->query("DELETE FROM tb_tamanhos");
	}
}
?>