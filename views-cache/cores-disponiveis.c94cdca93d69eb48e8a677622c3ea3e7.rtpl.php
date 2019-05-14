<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<input type="button" class="btn btn-success" value="voltar" onclick="history.go(-2)">
</section>
<!-- Main content -->
<section class="content" style="text-align: center;">
	<div>
		<h3 style="margin-bottom: 1em">Cores Cadastradas</h3>
		<table class="table table-striped" style="text-align: center;margin: 0 auto; width: 50%;">
			<thead>
				<tr>
					<td><strong>Imagem Prod</strong></td>
					<td><strong>Cor</strong></td>
					<td><strong>Cod. Modelo</strong></td>
					<td><strong>Disponível</strong></td>
				</tr>
			</thead>
			<?php $counter1=-1;  if( isset($infomodelo) && ( is_array($infomodelo) || $infomodelo instanceof Traversable ) && sizeof($infomodelo) ) foreach( $infomodelo as $key1 => $value1 ){ $counter1++; ?>
				<tr>
					<td><img src="https://www.bebefofuxo.com.br/lojas/00020368/prod/<?php echo htmlspecialchars( $value1["imagem_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="height: 10%; border:solid 1px black;"></td>
					<td><?php echo htmlspecialchars( $value1["nome_cor"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
					<td><?php echo htmlspecialchars( $value1["cod_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
					<td><?php if( $value1["disponivel"] == 1 ){ ?>Sim<?php }else{ ?>Não<?php } ?></td>
				</tr>
			<?php } ?>
		</table>
		<h3> Deseja ativar alguma cor? </h3>
		<a href="/admin/cores-corretas">
			<input type="submit" class="btn btn-success" name="btnNão" value="Não">
		</a>
		<a href="/admin/cores-indisponiveis">
			<input type="submit" class="btn btn-success" name="btnSim" value="Sim">
		</a>
	<div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->