<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<input type="button" class="btn btn-success" value="voltar" onclick="history.go(-1)">
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<h3> Digite as cores a serem cadastradas: </h3>
	<form action="/admin/cores-novas" method="post">
		<input type="text" name="txtCor1" placeholder="Cor" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtCor2" placeholder="Cor" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtCor3" placeholder="Cor" style="margin-top: 1em;">
		<br>
		<input type="submit" class="btn btn-success" name="btnAdicionarCores" value="Enviar" style="margin-top: 1em;">
	</form>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->