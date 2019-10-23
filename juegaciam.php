<?php
	//Cambio realizado en la rama new_master

	//CABECERA DE HTML
	include('cabecera.php');

	//Templo = 100 madera, 50 piedra, 50 oro
	//Almacen = 150 madera, 25 piedra, 100 comida
	//Cuartel = 75 madera, 25 piedra, 50 comida, 20 oro

	//session_destroy();
	//Cada minuto: -20 comida, -10 oro --> OPCIONAL PARA EL FINAL
	
   
    if(isset($_SESSION["intervalo"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL2 = time() - $_SESSION["intervalo"];
        $num_decremento = $sessionTTL2 / 5;
        $_SESSION['suministros']['oro']-=round($num_decremento);
            
    } 

    $_SESSION["intervalo"] = time();




	//Stock inicial 2000 de cada
	if (!isset($_SESSION['suministros'])) {
		//La primera vez, para crear la sesión
		$_SESSION['suministros'] = array();
		$_SESSION['suministros']['oro'] = 2000;
		$_SESSION['suministros']['madera'] = 2000;
		$_SESSION['suministros']['comida'] = 2000;
		$_SESSION['suministros']['marmol'] = 2000;

		$_SESSION['edificios'] = array();
		$_SESSION['edificios']['almacenes'] = 0;
		$_SESSION['edificios']['cuarteles'] = 0;
		$_SESSION['edificios']['templos'] = 0;
	}


	$oro = $_SESSION['suministros']['oro'];
	$madera = $_SESSION['suministros']['madera'];
	$comida = $_SESSION['suministros']['comida'];
	$marmol = $_SESSION['suministros']['marmol'];
	$num_almacenes = $_SESSION['edificios']['almacenes'];
	$num_cuarteles = $_SESSION['edificios']['cuarteles'];
	$num_templos = $_SESSION['edificios']['templos'];

	//Comprobamos que botón de construcción se ha pulsado
	if (isset($_POST['almacen_x'])) {
		//Construimos almacén
		if ( ($madera >= 150) && ($marmol >= 25) && ($comida >= 100) ) {
			//A construir
			$_SESSION['edificios']['almacenes']++;
			$num_almacenes++;

			//Decrementar stock
			$_SESSION['suministros']['madera']-=150;
			$_SESSION['suministros']['marmol']-=25;
			$_SESSION['suministros']['comida']-=100;
			$madera = $_SESSION['suministros']['madera'];
			$comida = $_SESSION['suministros']['comida'];
			$marmol = $_SESSION['suministros']['marmol'];
		}
	}
	//Construimos templo
	if (isset($_POST['templo_x'])) {
		//Mirar si hay recursos
		if ( ($madera >= 100) && ($marmol >= 50) && ($oro >= 50) ) {
			//A construir
			$_SESSION['edificios']['templos']++;
			$num_templos++;

			//Decrementar stock
			$_SESSION['suministros']['madera']-=100;
			$_SESSION['suministros']['marmol']-=50;
			$_SESSION['suministros']['oro']-=50;
			$madera = $_SESSION['suministros']['madera'];
			$oro = $_SESSION['suministros']['oro'];
			$marmol = $_SESSION['suministros']['marmol'];
		}
	}
	//Construimos cuartel
	if (isset($_POST['cuartel_x'])) {
		//Mirar si hay recursos
		if ( ($madera >= 75) && ($marmol >= 25) && ($oro >= 20) && ($comida >= 50)) {
			//A construir
			$_SESSION['edificios']['cuarteles']++;
			$num_cuarteles++;

			//Decrementar stock
			$_SESSION['suministros']['madera']-=75;
			$_SESSION['suministros']['marmol']-=25;
			$_SESSION['suministros']['oro']-=20;
			$_SESSION['suministros']['comida']-=50;
			$madera = $_SESSION['suministros']['madera'];
			$oro = $_SESSION['suministros']['oro'];
			$marmol = $_SESSION['suministros']['marmol'];
			$comida = $_SESSION['suministros']['comida'];
		}
	}

?>



<section>

	<h3 id ="oro"><?php print $oro; ?></h3>
	<h3 id="madera"><?php print $madera; ?></h3>
	<h3 id="comida"><?php print $comida; ?></h3>
	<h3 id="marmol"><?php print $marmol; ?></h3>


	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

	    	<input type="image" src="imgs/crear_almacen.gif" name="almacen" value="almacen">
	    	<input type="image" src="imgs/crear_templo.gif" name="templo" value="templo">
	    	<input type="image" src="imgs/crear_cuartel.gif" name="cuartel" value="cuartel">	  


	</form>
</section>

<?php
	print "<p>";
	print "<span>Templos: $num_templos</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Cuarteles: $num_cuarteles</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Almacenes: $num_almacenes</span>";
	print "</p>";

?>



<?php
	//PIE DE PÁGINA
	include('pie.php');
?>