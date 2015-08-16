<nav class="navbar navbar-default">
    <div class="collapse navbar-collapse" id="menu">
      <ul class="nav navbar-nav">
      <?php 
	      foreach ( $this->atributos['enlaces']  as $nombrePagina => $enlace ) {
	      	echo "<li class='linkMenu'><a href='$enlace'>$nombrePagina</a></li>";
	      }
      ?>
      </ul>      
    </div>
</nav>
