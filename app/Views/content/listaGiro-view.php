<div class="container is-fluid mb-6">
	<h1 class="title">Giros</h1>
	<h2 class="subtitle">Lista de giros</h2>
</div>
<div class="container pb-6 pt-6">

	
	<?php
		use app\controllers\GiroController;
		$inicio_sesion = new GiroController(); 
		echo $inicio_sesion->listarGiroController($url[1],15,$url[0],"");
	?>
</div>