<?php 
/*
 *  Sintaxis recomendada para las plantillas PHP
 */ 
?>
<ul class="nav nav-tabs">	 
	<?php foreach ( $this->atributos['enlaces']  as $nombrePagina => $enlace ): ?>
		<?php if (is_array($enlace)): ?>
			<li class="dropdown">
		      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		      	<?php echo $nombrePagina ?><span class="caret"></span>
		      </a>
		      <ul class="dropdown-menu">
		      	<?php foreach ( $enlace  as $nombrePagina => $enlace ) : ?>
					<li class='linkMenu'><a href='<?php echo $enlace ?>'><?php echo $nombrePagina ?></a></li>
				<?php endforeach; ?>
		      </ul>
		    </li>
		<?php else: ?>
			<li class='linkMenu'><a href='<?php echo $enlace ?>'><?php echo $nombrePagina ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
  </ul>
  <br />
