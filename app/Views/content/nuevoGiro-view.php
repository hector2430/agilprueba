<div class="container is-fluid mb-6">
	<h1 class="title">Giro</h1>
	<h2 class="subtitle">Nuevo Giro</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL?>app/ajax/GiroAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="modulo_giro" value="registrar">
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Cóodigo Giro</label>
				  	<input class="input" type="number" name="giro_cod"  maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="nombre_giro"  maxlength="40" required >
				</div>
		  	</div>
		</div>
		
		
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>