<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

<link rel="stylesheet" href="/res/admin/css/produto-novo.css">

</section>
<!-- Main content -->
<section class="content">
	<h3>Contagem de Produto Novo</h3>
	<br>
	<form action="/admin/inserir-contagem-novo" method="post">
	<div id="contagem-produto-novo">
	<div id="div-nome">
		<input class="txt-prod-novo" type="text" id="txtNome" placeholder="Nome Produto">
		<button id="btnNome" type="button">+</button>
		<label id="lblNome" style="display: none"></label>
		<br>
		<h5 id="msg-erro-nome" style="color: red; display: none;">O nome não pode ser em branco!</h5>
	</div>
	<div id="atributos">
		<label id="lblCores" style="display: none"></label>
		<br>
		<label id="lblTamanhos"></label>
		<br>
		<input class="txt-prod-novo" type="text" id="txtCor" placeholder="Cor">
		<button id="addCor" type="button">+</button>
		<br>
		<h5 id="msg-erro-cor" style="color: red; display: none;">A cor não pode ser em branco!</h5>
		<input class="txt-prod-novo" type="text" id="txtTamanho" placeholder="Tamanho">
		<button id="addTamanho" type="button">+</button>
		<br>
		<h5 id="msg-erro-tamanho" style="color: red; display: none;">O tamanho não pode ser em branco!</h5>
	</div>
	<br>
	<button id="btnContar" type="submit">Contar</button>
	</div>
	</form>
</section>
<script src="/res/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/res/admin/js/produto-novo.js"></script>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
