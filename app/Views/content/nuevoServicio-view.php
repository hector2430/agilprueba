<div class="container is-fluid mb-6">
	<h1 class="title">Servicio</h1>
	<h2 class="subtitle">Nuevo servicio</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL?>app/ajax/servicioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="modulo_servicio" value="registrar">
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="nombre"  maxlength="40" required >
				</div>
		  	</div>
		</div>
        <?php
            use app\controllers\servicioController;
            $listaTipo = new servicioController(); 
            echo $listaTipo->listarTipoServicio();
        ?>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>