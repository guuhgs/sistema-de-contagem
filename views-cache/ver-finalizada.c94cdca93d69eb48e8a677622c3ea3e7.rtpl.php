<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <input type="button" class="btn btn-success" value="voltar" onclick="history.go(-1)">
  <br>
   <h3>Cod Modelo: <?php echo htmlspecialchars( $cod, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
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
                      <th><center>Tamanho</center></th>
                      <th><center>Cor</center></th>
                      <th><center>Nome Contador1</center></th>
                      <th><center>Qtde Contador1</center></th>
                      <th><center>Nome Contador2</center></th>
                      <th><center>Qtde Contador2</center></th>
                      <th><center>Quantidade Correta</center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter1=-1;  if( isset($info) && ( is_array($info) || $info instanceof Traversable ) && sizeof($info) ) foreach( $info as $key1 => $value1 ){ $counter1++; ?>
                    <tr>
                      <th><center><?php echo htmlspecialchars( $value1["id_contagem"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      
                      <?php if( $value1["tamanho_prod"] != '' ){ ?>
                        <th><center><?php echo htmlspecialchars( $value1["tamanho_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php }else{ ?>
                        <th><center>N/D</center></th>
                      <?php } ?>

                      <?php if( $value1["cor_prod"] != '' ){ ?>
                        <th><center><?php echo htmlspecialchars( $value1["cor_prod"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php }else{ ?>
                        <th><center>N/D</center></th>
                      <?php } ?>

                      <th><center><?php echo htmlspecialchars( $value1["nome_cont1"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>

                      <?php if( $value1["qtde_cont1"] != $value1["qtde_correta"] ){ ?>
                        <th style="color: red"><center><?php echo htmlspecialchars( $value1["qtde_cont1"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php }else{ ?>
                        <th><center><?php echo htmlspecialchars( $value1["qtde_cont1"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php } ?>

                      <th><center><?php echo htmlspecialchars( $value1["nome_cont2"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>

                      <?php if( $value1["qtde_cont2"] != $value1["qtde_correta"] ){ ?>
                        <th style="color: red"><center><?php echo htmlspecialchars( $value1["qtde_cont2"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php }else{ ?>
                        <th><center><?php echo htmlspecialchars( $value1["qtde_cont2"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
                      <?php } ?>
                      
                      <th><center><?php echo htmlspecialchars( $value1["qtde_correta"], ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
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