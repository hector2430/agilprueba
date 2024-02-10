<div class="container is-fluid mb-6">
	<h1 class="title">Negocios</h1>
	<h2 class="subtitle">Lista de negocios</h2>
</div>
<div class="container pb-6 pt-6">

	
	<?php
		use app\controllers\NegocioController;
		$inicio_sesion = new NegocioController(); 
		echo $inicio_sesion->listarNegocioController($url[1],15,$url[0],"");
	?>
</div>