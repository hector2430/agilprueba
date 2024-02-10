<div class="container is-fluid mb-6">
	<h1 class="title">Negocio</h1>
	<h2 class="subtitle">Nuevo Negocio</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL?>app/ajax/negocioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="modulo_negocio" value="registrar">
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Rut empresa</label>
				  	<input class="input" type="number" name="negocio_rut"  maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Numero_Cuenta</label>
				  	<input class="input" type="number" name="negocio_numero_cuenta"  maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="negocio_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre representante legal</label>
				  	<input class="input" type="text" name="negocio_nombre_representante" maxlength="70" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Razón Social</label>
				  	<input class="input" type="text" name="negocio_razon_social" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="100" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Tipo Negocio</label>
				  	<input class="input" type="number" name="negocio_tipo"  maxlength="100" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
            <div class="column">
		    	<div class="control">
					<label>Giro</label>
				  	<input class="input" type="text" name="negocio_giro"  maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
				<div class="control">
					<label>Dependientes</label>
				  	<input class="input" type="text" name="negocio_dependientes"  maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
            <div class="column">
		    	<div class="control">
					<label>Dirección</label>
				  	<input class="input" type="text" name="negocio_direccion"  maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
				<div class="file has-name is-boxed">
					<label class="file-label">
						<input class="file-input" type="file" name="negocio_foto" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
		  	</div>
		</div>
		
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>