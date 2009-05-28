
	<div id="content" class="login_form">
	  
		  <h3>Iniciando sesi&oacute;n</h3>
		  
		  <div id="notice">
		    Si ya has creado un blog en LaMula, puedes iniciar sesión usando los mismos datos.
		    Si no, <?php echo anchor('/usuarios/formulario', 'crea tu cuenta ahora') ?>. &iexcl;Es r&aacute;pido!
		  </div>
		  
  		<div class="info">
  			<?php if (isset($info)) { echo $info; } ?>
  			<?php echo form_open('log/login', array('class' => 'log'));
  				echo form_hidden('destino', $destino);					
  			?>
  			<fieldset>
  			  
  			<?php echo form_label('Usuario:', 'usuario');?> 
  			<?php echo form_error('usuario'); ?>  			
  			<?php echo form_input(array('id' => 'usuario', 'name' => 'usuario', 'value' => set_value('usuario'))); ?>
  			</fieldset>
  			<fieldset>
  			<?php echo form_label('Contraseña:', 'password');?> 
  			<?php echo form_error('password'); ?>  			
  			<?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
  			</fieldset>
  			<?php echo form_submit(array('class' => 'boton', 'name' => 'mysubmit', 'value' => 'iniciar' )); ?>
  			<?php echo form_close(); ?>
  		</div> <!-- info -->
  		
  		<div id="pie">
  		  <?php echo anchor('log/olvido', 'Olvid&eacute; mi contraseña >>') ?> <br />
  		  <?php echo anchor('/usuarios/formulario', 'Crear una cuenta >>') ?>
		  </div>

	</div> <!-- content -->
	