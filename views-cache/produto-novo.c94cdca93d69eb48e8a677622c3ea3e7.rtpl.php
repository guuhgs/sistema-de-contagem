<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<h3>Contar Produto Novo </h3>
	<form action="/admin/produto-novo" method="post" style="width: 50%; margin: 0 auto; padding: 10px;">
		<input type="text" name="txtCor1" placeholder="Nome" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtCor2" placeholder="Cores Ex: azul,verde,preto" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtCor3" placeholder="Tamanhos" style="margin-top: 1em;">
		<br>
		<input type="submit" class="btn btn-success" name="btnAdicionarCores" value="Contar" style="margin-top: 1em;">
	</form>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->