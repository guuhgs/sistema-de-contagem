<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<input type="button" class="btn btn-success" value="voltar" onclick="history.go(-1)">
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<h3> Digite os tamanhos a serem cadastrados: </h3>
	<form action="/admin/tamanhos-novos" method="post">
		<input type="text" name="txtTamanho1" placeholder="Tamanho" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtTamanho2" placeholder="Tamanho" style="margin-top: 1em;">
		<br>
		<input type="text" name="txtTamanho3" placeholder="Tamanho" style="margin-top: 1em;">
		<br>
		<input type="submit" class="btn btn-success" value="Enviar" style="margin-top: 1em;">
	</form>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->