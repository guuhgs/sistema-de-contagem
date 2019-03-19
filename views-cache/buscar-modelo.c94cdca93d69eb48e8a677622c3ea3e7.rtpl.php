<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

	<input type="button" class="btn btn-success" value="voltar" onclick="history.go(-1)">
 
</section>

<!-- Main content -->
<section class="content">
	<div style="text-align: center; margin: 0 auto;">
		<h3><?php echo htmlspecialchars( $nome, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
		<br>
		<img src=<?php echo htmlspecialchars( $imagem, ENT_COMPAT, 'UTF-8', FALSE ); ?> style="height: 200px; width: 200px; border:solid 1px black;">
		<h3>Esse modelo está correto?</h3>
		<a href="/admin/criar-contagem">
			<input type="submit" class="btn btn-success" name="btnNão" value="Não">
		</a>
		<a href="/admin/cores-disponiveis">
			<input type="submit" class="btn btn-success" name="btnSim" value="Sim">
		</a>
	</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->