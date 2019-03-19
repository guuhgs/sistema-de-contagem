<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h3>Contagens</h3>
</section>
<!-- Main content -->
<section class="content">
 <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body no-padding">
              <form action="/admin/gerar-planilha" method="post">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th><center>#</center></th>
                      <th><center>Cod. Modelo</center></th>
                      <th><center>Data Abertura</center></th>
                      <th><center>Hora Inicio</center></th>
                      <th><center>Hora Fim</center></th>
                      <th><center>Adm</center></th>
                      <th><center>Status</center></th>
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
                        <?php if( $value1["desc_status"] == 'Aguardando Verificacao' ){ ?>
                        <a href="/admin/verificar-contagem/<?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn-verde btn btn-xs"><i class="fa fa-pen"></i>Verificar</a>
                      	
                        <?php }elseif( $value1["desc_status"] == 'Contagem Com Erro' ){ ?>
                        <a href="/iniciar-recontagem/<?php echo htmlspecialchars( $value1["cod_modelo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Recontar</a>

                        <?php } ?>
                        <a href="/admin/ver-contagens/<?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                      </th>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <br>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->