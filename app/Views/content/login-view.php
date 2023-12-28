<div class="main-container">

    <form class="box login" action="" method="POST" autocomplete="off" >
		<h5 class="title is-5 has-text-centered is-uppercase">LOGIN</h5>

		<div class="field">
			<label class="label">Correo</label>
			<div class="control">
			    <input class="input" type="email" name="login_correo"  maxlength="20" required >
			</div>
		</div>

		<div class="field">
		  	<label class="label">Contraseña</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_contrasena" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
		  	</div>
		</div>

		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
		</p>

	</form>
</div>

<?php

	if(isset($_POST["login_correo"]) && isset($_POST["login_contrasena"])  ){
		$inicio_sesion->inicioSesionController();
	}

?>
