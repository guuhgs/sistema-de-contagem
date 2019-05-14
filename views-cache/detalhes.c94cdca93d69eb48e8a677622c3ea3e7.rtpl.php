<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
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
              	<tbody>
		  			      <?php $counter1=-1;  if( isset($info) && ( is_array($info) || $info instanceof Traversable ) && sizeof($info) ) foreach( $info as $key1 => $value1 ){ $counter1++; ?>
  			  				  <tr>
  			  					  <th><center><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></center></th>
  			  				  </tr>
		  			      <?php } ?>
	  			      </tbody>
		  		    </table>
              <br>
		  		    <center><a href="/admin/contagens-tratamento" class="btn btn-primary btn-success">Voltar</a></center>
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
