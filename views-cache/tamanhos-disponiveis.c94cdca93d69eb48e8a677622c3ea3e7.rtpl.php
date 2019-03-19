<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

	<a href="/admin/criar-contagem"><input type="button" class="btn btn-success" value="voltar"></a>
	
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<div>
		<h3 style="margin-bottom: 1em">Tamanhos Dísponiveis</h3>
		<table class="table table-striped" style="border:1px solid; text-align: center; margin: 0 auto; width: 50%;">
			<thead>
				<tr>
					<th style="border:1px solid;"><center><strong>Ref.</strong></center></th>
					<th style="border:1px solid;"><center><strong>Tamanho</strong></center></th>
				</tr>
			</thead>
			<?php $counter1=-1;  if( isset($info) && ( is_array($info) || $info instanceof Traversable ) && sizeof($info) ) foreach( $info as $key1 => $value1 ){ $counter1++; ?>
				<tr>
					<th style="border:1px solid;"><center><?php echo htmlspecialchars( $value1["cod_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
					<th style="border:1px solid;"><center><?php echo htmlspecialchars( $value1["nome_tamanho"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
				</tr>
			<?php } ?>
		</table>
		<a href="/admin/tamanhos-novos">
			<input type="submit" style="margin-top: 2em; margin-right: 1em;" class="btn btn-success" value="Solicitar cadastro de tamanho novo">
		</a>
		<a href="/admin/inserir-contagem">
			<input type="submit" style="margin-top: 2em;" class="btn btn-success" value="Continuar">
		</a>
	<div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->