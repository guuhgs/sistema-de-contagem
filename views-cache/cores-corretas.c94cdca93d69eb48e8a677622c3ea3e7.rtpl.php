<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<input type="button" class="btn btn-success" value="voltar" onclick="history.go(-1)">
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<div>
		<h3 style="margin-bottom: 1.5em">As cores para iniciar a contagem são:</h3>
		<table class="table table-striped" style="text-align: center;margin: 0 auto; width: 50%;">
			<thead>
				<tr>
					<td><strong>Imagem Prod</strong></td>
					<td><strong>Cor</strong></td>
					<td><strong>Cod. Modelo</strong></td>
				</tr>
			</thead>
			<?php $counter1=-1;  if( isset($infomodelo) && ( is_array($infomodelo) || $infomodelo instanceof Traversable ) && sizeof($infomodelo) ) foreach( $infomodelo as $key1 => $value1 ){ $counter1++; ?>
			<tr>
				<td><img src="https://www.bebefofuxo.com.br/lojas/00020368/prod/<?php echo htmlspecialchars( $value1["imagem_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="height: 10%; border:solid 1px black;"></td>
				<td><?php echo htmlspecialchars( $value1["nome_cor"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
				<td><?php echo htmlspecialchars( $value1["cod_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
				<td><?php if( $value1["disponivel"] == 2 ){ ?><a href="/admin/cores-corretas/<?php echo htmlspecialchars( $value1["nome_cor"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a><?php }else{ ?><?php } ?></td>
			</tr>
			<?php } ?>
		</table>
		<a href="/admin/cores-novas">
			<input type="submit" style="margin-top: 2em; margin-right: 1em;" class="btn btn-success" value="Solicitar cadastro de cor nova">
		</a>
		<a href="/admin/tamanhos-disponiveis">
			<input type="submit" style="margin-top: 2em;" class="btn btn-success" value="Continuar">
		</a>
	</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->