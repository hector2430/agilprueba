<div class="container is-fluid mb-6">

    <?php
    $id_negocio = $inicio_sesion->limpiarCadena($url[1]); 
    /*
    if($id == $_SESSION["id_usuario"]){
    ?>
        <h1 class="title">Mi Negocio</h1>
        <h2 class="subtitle">Actualizar Negocio</h2>
    <?php
    }else{
    ?>
        <h1 class="title">Negocios</h1>
        <h2 class="subtitle">Actualizar Negocio</h2>
    <?php
    }
	?>
    */
    ?>
    <h1 class="title">Negocios</h1>
    <h2 class="subtitle">Actualizar Negocio</h2>
</div>
<div class="container pb-6 pt-6">
	
    <?php
        include "./app/views/inc/btn_back.php";
        $datos= $inicio_sesion->seleccionarDatos("Unico","t_negocio","Negocio_Dni",$id_negocio);

        if($datos->rowCount() == 1){
            $datos=$datos->fetch();
    ?>

	<h2 class="title has-text-centered"><?php echo  $datos["Nombre_Negocio"]; ?></h2>


	<form class="FormularioAjax" action="<?php echo APP_URL;?>app/ajax/negocioAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_negocio" value="actualizar">
		<input type="hidden" name="negocio_id" value="<?php echo $id_negocio;?>">
        <input type="hidden" name="nombre_negocio" value="<?php echo $datos["Nombre_Negocio"];?>">
        <input type="hidden" name="usuario_id" value="<?php echo $_SESSION["id_usuario"];?>">


		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Numero de cuenta</label>
				  	<input class="input" type="text" value="<?php echo  $datos["Numero_Cuenta"] ?>" name="negocio_numero_cuenta"  maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Representante Legal</label>
				  	<input class="input" type="text "value="<?php echo $datos["Nombre_Representante_Legal"] ?>" name="negocio_nombre_representante_legal"  maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Direcion</label>
				  	<input class="input" type="text" value="<?php echo  $datos["Direccion"] ?>" name="negocio_direccion" maxlength="70" >
				</div>
		  	</div>
              <div class="column">
		    	<div class="control">
					<label>Razón social</label>
				  	<input class="input" type="text "value="<?php echo $datos["Razon_Social"] ?>" name="negocio_razon_Social"  maxlength="40" required >
				</div>
		  	</div>
		</div>
        <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Dependientes</label>
				  	<input class="input" type="text" value="<?php echo  $datos["Dependientes"] ?>" name="negocio_dependientes" maxlength="70" >
				</div>
		  	</div>
              <div class="column">
		    	<div class="control">
					<label>Giro</label>
				  	<input class="input" type="text "value="<?php echo $datos["id_giro"] ?>" name="negocio_giro" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<br><br>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	
    <?php
        }else{
            include "./app/views/inc/error_alerta.php";
        }
    ?>

</div>