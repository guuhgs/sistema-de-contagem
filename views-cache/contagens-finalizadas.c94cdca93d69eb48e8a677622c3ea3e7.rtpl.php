<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h3>Contagens Finalizadas</h3>
</section>
<!-- Main content -->
<section class="content">
 <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped tabela-responsiva">
                  <thead>
                    <tr>
                      <th><center>#</center></th>
                      <th><center>Cod. Modelo</center></th>
                      <th><center>Data Abertura</center></th>
                      <th><center>Hora Inicio</center></th>
                      <th><center>Hora Fim</center></th>
                      <th><center>Adm</center></th>
                      <th><center>Status</center></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter1=-1;  if( isset($info) && ( is_array($info) || $info instanceof Traversable ) && sizeof($info) ) foreach( $info as $key1 => $value1 ){ $counter1++; ?>
                    <tr>
                      <th><center><?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["cod_modelo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["data_cont"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["hora_inicio"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["hora_fim"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["nome_usuario"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th><center><?php echo htmlspecialchars( $value1["desc_status"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <th>
                          <a href="/admin/ver-finalizada/<?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><button class="btn btn-primary btn-xs">Ver</button></a>
                      </th>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <br>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->