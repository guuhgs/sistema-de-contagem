<?php if(!class_exists('Rain\Tpl')){exit;}?><html>
	<head>
		<title>Sistema de Contagem</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<link rel="stylesheet" type="text/css" href="/res/admin/css/tabela.css">

		<link rel="stylesheet" href="/res/admin/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="/res/admin/dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
		    page. However, you can choose any other skin. Make sure you
		    apply the skin class to the body tag so the changes take effect.-->
		<link rel="stylesheet" href="/res/admin/dist/css/skins/skin-blue.min.css">		
	</head>
<body>
	<div class="content" style="text-align: center;">
		<table class="tabela tabelaEditavel table-striped" id="tabela1" border="1">
			<thead>
				<tr>
					<input type="hidden" id="idContagem" value="<?php echo htmlspecialchars( $idContagem, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
					<th><center>cor</center></th>
					<?php $counter1=-1;  if( isset($th) && ( is_array($th) || $th instanceof Traversable ) && sizeof($th) ) foreach( $th as $key1 => $value1 ){ $counter1++; ?>
						<th><strong><center><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></center></strong></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php $counter1=-1;  if( isset($td) && ( is_array($td) || $td instanceof Traversable ) && sizeof($td) ) foreach( $td as $key1 => $value1 ){ $counter1++; ?>
				<tr>
					<th><center><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
					<?php $counter2=-1;  if( isset($tdsVazias) && ( is_array($tdsVazias) || $tdsVazias instanceof Traversable ) && sizeof($tdsVazias) ) foreach( $tdsVazias as $key2 => $value2 ){ $counter2++; ?>
					<td><?php echo htmlspecialchars( $value2["a"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
					<?php } ?>
				<?php } ?>
				</tr>
			</tbody>	
		</table>
		<br>
		<button id="btnFinalizar" class="btn btn-success">Finalizar</button>
	</div>
</body>

<!-- jQuery 2.2.3 -->
<script src="/res/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/res/admin/bootstrap/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="/res/admin/dist/js/app.min.js"></script>

<!-- Meus JS -->
<script src="/res/admin/js/redirect.js"></script>
<script src="/res/admin/js/tabela.js"></script>
<script src="/res/admin/js/finalizarCont.js"></script>

<!-- Plugin table to JSON -->
<script src="https://cdn.jsdelivr.net/npm/table-to-json@0.13.0/lib/jquery.tabletojson.min.js"></script>