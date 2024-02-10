<div class="container is-fluid mb-6">
	<h1 class="title">Tipos de servicios</h1>
	<h2 class="subtitle">Lista de tipos de servicios</h2>
</div>
<div class="container pb-6 pt-6">

	
	<?php
		use app\controllers\tipo_servicio_Controller;
		$inicio_sesion = new tipo_servicio_Controller(); 
		echo $inicio_sesion->listarTipoServicioController($url[1],15,$url[0],"");
	?>
</div>