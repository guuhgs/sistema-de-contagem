<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\AtualizaDados;
use \Hcode\BuscarModelo;
use \Hcode\Contagem;
use \Hcode\EnviarEmail;
use \Hcode\Model\User;
use \Hcode\DB\Sql;

$app = new Slim();

$app->config('debug', true);

$app->get('/login', function(){

	$page = new PageAdmin([
			'header'=>false,
			'footer'=>false
	]);

	$page->setTpl("login");
});

$app->post('/login', function(){

	User::login($_POST["desemail"], $_POST["dessenha"]);

	User::verifyUserType();
});

$app->get('/', function() {

	User::verifyLogin();

	$page = new Page();
	$page->setTpl("index");
});

$app->get('/admin', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTpl("index");
});

$app->get('/logout', function(){

	User::logout();

	header('Location: /login');
	exit;
});

$app->get('/admin/users', function(){

	User::verifyLogin();
	User::verifyADM();

	$users = User::listAll();
	$page = new PageAdmin();
	$page->setTpl('users', array(
		'users'=>$users
	));
});

$app->get('/admin/users/create', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTpl('users-create');
});

$app->get('/admin/criar-contagem', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTpl('criar-contagem');
});

$app->post('/admin/buscar-modelo', function(){

	User::verifyLogin();
	User::verifyADM();

	$codModelo = $_POST['txtCodModelo'];

	$b = new BuscarModelo();

	$b->limparSessao();

	$infoProd = $b->buscar($codModelo);

	$buscarTamanhos = $b->buscarTamanho($codModelo);

	$tamanhos = [];

	foreach ($buscarTamanhos as $value) {

		array_push($tamanhos, $value['nome_tamanho']);
	}

	$_SESSION['tamanhos'] = $tamanhos;

	$_SESSION['infoProd'] = $infoProd;

	$_SESSION['cod'] = $codModelo;

	if(count($infoProd) > 0){

		$page = new PageAdmin();

		$imagem = "https://www.bebefofuxo.com.br/lojas/00020368/prod/".$infoProd['0']['imagem_prod'];

		$page->setTpl('buscar-modelo',array('imagem'=>$imagem,'nome'=>$infoProd['0']['nome_prod']));

	} else {

		echo "Produto não encontrado!";
	}
});

$app->get('/admin/produto-novo', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();

	$page->setTpl('produto-novo');

});

$app->get('/admin/ver-contagens', function(){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();
	$info = $c->buscarContagens();

	$page = new PageAdmin();
	$page->setTpl('ver-contagens', array("info"=>$info));
});

$app->get('/ver-contagens', function(){

	User::verifyLogin();

	$idCont = $_SESSION['User']['id_usuario'];

	$c = new Contagem();
	$info = $c->buscarContagens();

	$page = new Page();
	$page->setTpl('ver-contagens', array("info"=>$info, "idCont"=>$idCont));
});

$app->get('/admin/contagens-finalizadas', function(){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();
	$info = $c->buscarContagensFinalizadas();

	$page = new PageAdmin();
	$page->setTpl('contagens-finalizadas', array("info"=>$info));
});

$app->get('/admin/dados-atualizados', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTpl('dados-atualizados');
});

$app->get('/admin/atualizar-dados',function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTPl('atualizar-dados');
});

$app->get('/admin/cores-disponiveis', function(){

	User::verifyLogin();
	User::verifyADM();

	$infoModelo = $_SESSION['infoProd'];

	$page = new PageAdmin();

	if(isset($infoModelo['0']['nome_cor'])){

		$page->setTpl('cores-disponiveis',array('infomodelo'=>$infoModelo));

	} else {

		header('Location: /admin/tamanhos-disponiveis');
		exit;
	}
});

$app->get('/admin/cores-indisponiveis', function(){

	User::verifyLogin();
	User::verifyADM();

	$infoModelo = $_SESSION['infoProd'];

	$indisponiveis = [];

	$page = new PageAdmin();

	foreach ($infoModelo as $value) {

		if($value['disponivel'] == 0){

			array_push($indisponiveis, $value);
		}
	}

	$_SESSION['indisponiveis'] = $indisponiveis;

	$page->setTpl('cores-indisponiveis', array('infomodeloi'=>$indisponiveis));
});

$app->get('/admin/cores-novas', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();

	$page->setTpl('cores-novas');
});

$app->get('/admin/tamanhos-disponiveis', function(){

	User::verifyLogin();
	User::verifyADM();

	$buscar = new BuscarModelo();

	if(isset($_SESSION['cod'])){

		$cod = $_SESSION['cod'];

	} else {

		$cod = $_POST['codModelo'];
	}

	$infoModelo = $buscar->buscarTamanho($cod);

	if(isset($_SESSION['tamanhosNovos'])){

		$tamanhosNovos = $_SESSION['tamanhosNovos'];

			foreach ($tamanhosNovos as $value) {

				array_push($infoModelo, $value);

			}

		$_SESSION['infoProd3'] = $infoModelo;
	}

	$tamanhos = [];

	foreach ($infoModelo as $value) {

		array_push($tamanhos, $value['nome_tamanho']);

	}

	$_SESSION['tamanhos'] = $tamanhos;

	if(count($infoModelo) > 0){

		$page = new PageAdmin();

		$imagem = "https://www.bebefofuxo.com.br/lojas/00020368/prod/".$infoModelo['0']['imagem_prod'];

		$page->setTpl('tamanhos-disponiveis',array('imagem'=>$imagem,'nome'=>$infoModelo['0']['nome_prod'],'info'=>$infoModelo));

	} else {

		header("Location: /admin/inserir-contagem");
		exit;
	}
});

$app->get('/admin/cores-corretas', function(){

	User::verifyLogin();
	User::verifyADM();

	if(isset($_SESSION['email'])){

		$infoEmail = $_SESSION['email'];

	} else {

		$infoEmail = [];
	}

	if(isset($_SESSION['indisponiveis'])){

		$indisponiveis = $_SESSION['indisponiveis'];

	} else {

		$indisponiveis = $_SESSION['infoProd'];
	}

	if(isset($_SESSION['disponiveis'])){

		$disponiveis = $_SESSION['disponiveis'];

	} else if(isset($_SESSION['infoProd2'])){

		$disponiveis = $_SESSION['infoProd2'];

	} else {

		$infoModelo = $_SESSION['infoProd'];

		$disponiveis = [];

		foreach ($infoModelo as $value) {

			if($value['disponivel'] == 1){

				array_push($disponiveis, $value);
			}
		}
	}

	foreach($indisponiveis as $value){

		if(isset($_GET['checkIndisponivel'.$value['nome_cor']])){

			$value['disponivel'] = 2;

			array_push($disponiveis, $value);

			$email = array(
					 'ativar_cod'=>$value['cod_prod'],
					 'ativar_cor'=>$value['nome_cor']
					 );

			array_push($infoEmail, $email);
		}
	}

	$_SESSION['infoProd2'] = $disponiveis;

	$_SESSION['email'] = $infoEmail;

	$cores = [];

	foreach ($disponiveis as $value) {

		if($value['disponivel'] == 1 or $value['disponivel'] == 2){

			array_push($cores, $value['nome_cor']);

		}
	}

	$_SESSION['cores'] = $cores;

	$page = new PageAdmin();

	$page->setTpl('cores-corretas',array('infomodelo'=>$disponiveis));
});

$app->get('/admin/cores-corretas/:nome_cor/delete', function($nome_cor){

	User::verifyLogin();
	User::verifyADM();

	$info = $_SESSION['infoProd2'];

	$disponiveis = [];

	$coresNovas = $_SESSION['cores-novas'];

	foreach ($coresNovas as $value) {

		if($value == $nome_cor){


		}

	}

	foreach($info as $value){

		if($value['nome_cor'] != $nome_cor){

			array_push($disponiveis, $value);
		}
	}

	$_SESSION['disponiveis'] = $disponiveis;

	header('Location: /admin/cores-corretas');
	exit;
});

$app->get('/admin/ver-contagens/:id_contagem/delete', function($idContagem){

	$contagem = new Contagem();
	$contagem->excluirContagem($idContagem);

	header('Location: /admin/ver-contagens');
	exit;
});

$app->get('/admin/contagens-finalizadas/:id_contagem/delete', function($idContagem){

	$contagem = new Contagem();
	$contagem->excluirContagem($idContagem);

	header('Location: /admin/contagens-finalizadas');
	exit;
});

$app->get('/admin/contagens-tratamento/:id_contagem/delete', function($idContagem){

	$contagem = new Contagem();
	$contagem->excluirContagem($idContagem);

	header('Location: /admin/contagens-tratamento');
	exit;
});

$app->get('/admin/users/:id_usuario/delete', function($id_usuario){

	User::verifyLogin();
	User::verifyADM();

	$user = new User();
	$user->get((int)$id_usuario);
	$user->delete();

	header('Location: /admin/users');
	exit;
});

$app->get('/admin/tamanhos-novos', function(){

	User::verifyLogin();
	User::verifyADM();

	$page = new PageAdmin();
	$page->setTpl('tamanhos-novos');
});

$app->post('/admin/tamanhos-novos', function(){

	User::verifyLogin();
	User::verifyADM();

	$TamanhoNovo1 = $_POST['txtTamanho1'];
	$TamanhoNovo2 = $_POST['txtTamanho2'];
	$TamanhoNovo3 = $_POST['txtTamanho3'];

	$tamanhosNovos = [];

	if(isset($TamanhoNovo1)){

		array_push($tamanhosNovos, $TamanhoNovo1);
	}

	if(isset($TamanhoNovo2)){

		array_push($tamanhosNovos, $TamanhoNovo2);
	}

	if(isset($TamanhoNovo3)){

		array_push($tamanhosNovos, $TamanhoNovo3);
	}

	if(isset($_SESSION['email'])){

		$email = $_SESSION['email'];

	} else {

		$email = [];
	}

	array_push($email, $tamanhosNovos);

	$_SESSION['email'] = $email;

	if(isset($_SESSION['infoProd2'])){

		$infoProd = $_SESSION['infoProd2'];

	} else {

		$infoProd = $_SESSION['infoProd'];
	}

	$tamanhosNovos2 = [];

	$tamanhos = $_SESSION['tamanhos'];

	foreach ($tamanhosNovos as $value) {

		if($value !== ""){

			for ($i=0; $i<count($tamanhosNovos); $i++) {

				$tamanho_novo = array(
						'id_produto'=>NULL,
						'cod_prod'=>$infoProd[0]['cod_prod'],
						'nome_prod'=>$infoProd[0]['nome_prod'],
						'disponivel'=>2,
						'imagem_prod'=>'bbfofuxo.jpg',
						'nome_cor'=>NULL,
						'nome_tamanho'=>$value
						);
			}

			array_push($tamanhos, $value);

			array_push($tamanhosNovos2, $tamanho_novo);
		}
	}

	$_SESSION['tamanhos'] = $tamanhos;

	$_SESSION['tamanhosNovos'] = $tamanhosNovos2;

	header('Location: /admin/tamanhos-disponiveis');
	exit;
});

$app->get('/admin/users/:id_usuario', function($id_usuario){

	User::verifyLogin();
	User::verifyADM();

	$user = new User();
	$user->get((int)$id_usuario);

	$page = new PageAdmin();

	$page->setTpl('users-update', array(
		'user'=>$user->getValues()
	));
});

$app->post('/admin/cores-novas', function(){

	User::verifyLogin();
	User::verifyADM();

	$corNova1 = $_POST['txtCor1'];
	$corNova2 = $_POST['txtCor2'];
	$corNova3 = $_POST['txtCor3'];

	$email = [];

	$coresNovas = [];

	if(isset($corNova1)){

		array_push($coresNovas, $corNova1);
	}

	if(isset($corNova2)){

		array_push($coresNovas, $corNova2);
	}

	if(isset($corNova3)){

		array_push($coresNovas, $corNova3);
	}

	array_push($email, $coresNovas);

	$_SESSION['cores-novas'] = $email;

	if(isset($_SESSION['infoProd2'])){

		$infoProd = $_SESSION['infoProd2'];

	} else {

		$infoProd = $_SESSION['infoProd'];
	}

	$tamanhos = $_SESSION['tamanhos'];

	$cores = $_SESSION['cores'];

	foreach ($coresNovas as $value) {

		if($value !== ""){

			if(count($tamanhos) > 0){

				$cor_nova = array(
						'id_produto'=>NULL,
						'cod_prod'=>$infoProd[0]['cod_prod'],
						'nome_prod'=>$infoProd[0]['nome_prod'],
						'disponivel'=>2,
						'imagem_prod'=>'bbfofuxo.jpg',
						'nome_cor'=>$value,
						'nome_tamanho'=>$tamanhos[0]
						);

					array_push($cores, $value);

					array_push($infoProd, $cor_nova);

			} else if(count($tamanhos) == 0){

				$cor_nova = array(
						'id_produto'=>NULL,
						'cod_prod'=>$infoProd[0]['cod_prod'],
						'nome_prod'=>$infoProd[0]['nome_prod'],
						'disponivel'=>2,
						'imagem_prod'=>'bbfofuxo.jpg',
						'nome_cor'=>$value
						);

					array_push($cores, $value);

					array_push($infoProd, $cor_nova);


			} else {

				for ($i=0; $i<count($cores) ; $i++){

					$cor_nova = array(
						'id_produto'=>NULL,
						'cod_prod'=>$infoProd[0]['cod_prod'],
						'nome_prod'=>$infoProd[0]['nome_prod'],
						'disponivel'=>2,
						'imagem_prod'=>'bbfofuxo.jpg',
						'nome_cor'=>$cores[$i],
						);
				}
			}
		}
	}

	$_SESSION['cores'] = $cores;

	if(isset($_SESSION['disponiveis'])){

		$_SESSION['disponiveis'] = $infoProd;


	} else if(isset($_SESSION['infoProd2'])){

		$_SESSION['infoProd2'] = $infoProd;

	} else {

		$_SESSION['infoProd'] = $infoProd;
	}

	header('Location: /admin/cores-corretas');
	exit;
});

$app->post('/admin/users/create', function(){

	User::verifyLogin();
	User::verifyADM();

	$user = new User();

	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:2;
	$_POST['senha_usuario'] = password_hash($_POST['senha_usuario'], PASSWORD_DEFAULT);

	$user->setData($_POST);
	$user->save();

	header("Location: /admin/users");
	exit;
});

$app->post('/admin/users/:id_usuario', function($id_usuario){

	User::verifyLogin();
	User::verifyADM();

	$user = new User();

	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:0;

	$user->get((int)$id_usuario);
	$user->setData($_POST);
	$user->update();

	header("Location: /admin/users");
	exit;
});

$app->post('/admin/atualizar-dados', function(){

	set_time_limit(2000);

	User::verifyLogin();
	User::verifyADM();

	$sql = new Sql();
	$ad = new AtualizaDados();

	$ad->deletarTamanhos($sql);
	$ad->atualizarTamanhos($sql);

	$ad->deletarCores($sql);
	$ad->atualizarCores($sql);

	$ad->deletarDadosFast($sql);
	$ad->atualizarDadosFast();

	$ad->deletarDadosOtix($sql);
	$ad->atualizarDadosOtix();

	header('Location: /admin/dados-atualizados');
	exit;
});

$app->get('/admin/inserir-contagem', function(){

	User::verifyLogin();

	$cod = $_SESSION['cod'];

	if(isset($_SESSION['cores'])){

		$cores = $_SESSION['cores'];
	} else {

		$cores = [];
	}

	if(isset($_SESSION['tamanhos'])){

		$tamanhos = $_SESSION['tamanhos'];
	} else {

		$tamanhos = [];
	}

	$b = new BuscarModelo();

	$info = $b->buscarModeloCont($cod, $cores, $tamanhos);

	$infoUser = $_SESSION['User'];

	$c = new Contagem();

	$idContagem = $c->inserirContagem($info, $infoUser);

	header("Location: /admin/ver-contagens");
	exit;
});

$app->post('/admin/inserir-contagem-novo', function(){

	User::verifyLogin();
	User::verifyADM();

	if(isset($_POST['cores'])){

		$cores = $_POST['cores'];
	}

	if(isset($_POST['tamanhos'])){

		$tamanhos = $_POST['tamanhos'];
	}

	if(isset($cores) and isset($tamanhos)){


	} else if(isset($cores) and $tamanhos = ""){

		echo "Tem apenas cores e não tem tamanhos"
	} else {

		echo "Tem apenas tamanhos e não tem cores";
	}
});

$app->get('/iniciar-contagem/:cod/:idContagem', function($cod, $idContagem){

	User::verifyLogin();

	$c = new Contagem();

	$dados = $c->buscarDados($idContagem);

	$th = $c->montarTH($dados); //tamanhos
	$td = $c->montarTD($dados,$cod); //cores

	$th2 = $c->ordenarArray($th);

	$tabela = $c->montarArray($td, $th2, $idContagem);

	$v = count($th2);

	$tdsVazias = [];
	$qtds = [];

	for ($i=0; $i<$v; $i++){

		$valores = array(
					"id"=>$tabela[$i]['id'],
					"a"=>"");

		array_push($tdsVazias, $valores);
	}

	$page = new Page([
			'header'=>false,
			'footer'=>false
	]);

	$page->setTpl('iniciar-contagem', array("td"=>$td,"th"=>$th2,"cod"=>$cod,"tdsVazias"=>$tdsVazias,"idContagem"=>$idContagem));
});

$app->get('/iniciar-recontagem/:cod/:idContagem', function($cod, $idContagem){

	User::verifyLogin();

	$c = new Contagem();

	$dados = $c->buscarDados($idContagem);

	$th = $c->montarTH($dados); //tamanhos
	$td = $c->montarTD($dados,$cod); //cores

	$th2 = $c->ordenarArray($th);

	$tabela = $c->montarArray($td, $th2, $idContagem);

	$v = count($th2);

	$tdsVazias = [];
	$qtds = [];

	for ($i=0; $i<$v; $i++){

		$valores = array(
					"id"=>$tabela[$i]['id'],
					"a"=>"");

		array_push($tdsVazias, $valores);
	}

	$page = new PageAdmin([
			'header'=>false,
			'footer'=>false
	]);

	$page->setTpl('iniciar-recontagem', array("td"=>$td,"th"=>$th2,"cod"=>$cod,"tdsVazias"=>$tdsVazias,"idContagem"=>$idContagem));
});

$app->post('/salvar-contagem/:idContagem', function($idContagem){

	User::verifyLogin();

	$tabela = $_POST['dados'];

	$idContador = $_SESSION['User']['id_usuario'];

	$c = new Contagem();

	$idProds = $c->buscarId($tabela,$idContagem);

	$c->salvarContagem($idProds, $idContagem, $idContador);

	header('Location: /ver-contagens');
	exit;
});

$app->post('/salvar-recontagem/:idContagem', function($idContagem){

	User::verifyLogin();
	User::verifyADM();

	$tabela = $_POST['dados'];

	$idContador = $_SESSION['User']['id_usuario'];

	$c = new Contagem();

	$idProds = $c->buscarId($tabela,$idContagem);

	$c->salvarRecontagem($idProds, $idContagem, $idContador);

	$status = $c->verificarContagem($idContagem);

	header('Location: /admin/ver-contagens');
	exit;
});

$app->get('/admin/verificar-contagem/:idContagem', function($idContagem){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();

	$c->verificarContagem($idContagem);

	header('Location: /admin/ver-contagens');
	exit;
});

$app->post('/admin/gerar-planilha', function(){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();

	$c->gerarExcel();

});

$app->get('/admin/contagens-tratamento', function(){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();
	$info = $c->buscarContagensTratamento();

	$page = new PageAdmin();
	$page->setTpl('contagens-tratamento', array("info"=>$info));

});

$app->get('/admin/detalhes/:idContagem', function($idContagem){

	User::verifyLogin();
	User::verifyADM();

	$sql = new Sql();

	$codigo = $sql->select("SELECT cod_modelo FROM tb_contagens WHERE id_contagem = $idContagem");

	$cod = $codigo[0]['cod_modelo'];

	if(isset($cod)){

		$c = new Contagem();

		$info = $c->buscarDetalhes($idContagem,$cod);
	}

	$page = new PageAdmin();
	$page->setTpl('detalhes', array('info'=>$info));
});

$app->post('/admin/finalizar-tratamento', function(){

	User::verifyLogin();
	User::verifyADM();

	$sql = new Sql();

	foreach($_POST as $key => $value){

		$sql->query("UPDATE tb_contagens
					  		 SET status_contagem = 3
					  		 WHERE id_contagem = $key");
	}

	header('Location: /admin/contagens-tratamento');
	exit;
});

$app->get('/admin/ver-finalizada/:idContagem', function($idContagem){

	User::verifyLogin();
	User::verifyADM();

	$c = new Contagem();

	$sql = new Sql();

	$cod = $sql->select("SELECT cod_modelo FROM tb_contagens WHERE id_contagem = $idContagem");

	$info = $c->verContagemFinalizada($idContagem);

	$page = new PageAdmin();

	$page->setTpl('ver-finalizada', array('info'=>$info,'cod'=>$cod[0]['cod_modelo']));
});

$app->run();

?>
