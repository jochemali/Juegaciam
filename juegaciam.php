<?php
	//CABECERA DE HTML
	include('cabecera.php');
	//session_destroy();
header("Refresh:5 url=juegaciam.php");
	//-Templo = 100 madera, 50 piedra, 50 oro
	//-Aserradero = 200 madera, 50 piedra
	//-Cantera = 200 piedra, 50 madera
	//-Cuartel = 75 madera, 25 piedra, 50 comida, 20 oro
	//-Huertos = 200 comida, 50 madera
	//-Mercado = 50 madera, 50 piedra, 100 oro

	//session_destroy();
	//Cada minuto: -20 comida, -10 oro --> OPCIONAL PARA EL FINAL
	
   
    if(isset($_SESSION["intervalo"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL2 = time() - $_SESSION["intervalo"];
        $num_decremento = $sessionTTL2 / 5;
        $num_incremento = $sessionTTL2 / 5;
        $_SESSION['suministros']['oro']-=round($num_decremento);		
        $_SESSION['suministros']['comida']-=round($num_incremento)*2;
	//Este número es 5 segundos; 10=Nº materias primas que proporciona; La sesión guarda la cantidad que tenemos y al multiplicarla
	//por la cantidad de materias primas que da --> materias ganadas cada 5 segundos;
		
		//Produce 10 de madera cada 5 segundos y aserradero construido
       $_SESSION['suministros']['madera']+=round($num_incremento)*10*$_SESSION['edificios']['aserraderos']; 
		//Produce 10 de piedra cada 5 segundos y cantera construido
	   $_SESSION['suministros']['marmol']+=round($num_incremento)*10*$_SESSION['edificios']['canteras'];
		//Produce 10 de comida cada 5 segundos y huerto construido
	   $_SESSION['suministros']['comida']+=round($num_incremento)*10*$_SESSION['edificios']['huertos'];
		//Produce 2 de oro cada 5 segundos y mercado construido
	   $_SESSION['suministros']['oro']+=round($num_incremento)*2*$_SESSION['edificios']['mercados'];
            
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
		$_SESSION['edificios']['cuarteles'] = 0;
		$_SESSION['edificios']['templos'] = 0;
		$_SESSION['edificios']['aserraderos'] = 0;
		$_SESSION['edificios']['canteras'] = 0;
		$_SESSION['edificios']['huertos'] = 0;
		$_SESSION['edificios']['mercados'] = 0;
	}

	//Si defino aquí estas variables podemos trabajar con ellas más a adelante
	$oro = $_SESSION['suministros']['oro'];
	$madera = $_SESSION['suministros']['madera'];
	$comida = $_SESSION['suministros']['comida'];
	$marmol = $_SESSION['suministros']['marmol'];

	//Comprobamos que botón de construcción se ha pulsado
	
	//Construimos templo
	if (isset($_POST['templo_x'])) {
		//Mirar si hay recursos
		if ( ($madera >= 100) && ($marmol >= 50) && ($oro >= 50) ) {
			//A construir
			$_SESSION['edificios']['templos']++;

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
	//Construimos aserradero
	if (isset($_POST['aserradero_x'])) {
		//Mirar si hay recursos
		if ( ($madera >= 200) && ($marmol >= 50)) {
			//A construir
			$_SESSION['edificios']['aserraderos']++;

			//Decrementar stock
			$_SESSION['suministros']['madera']-=200;
			$_SESSION['suministros']['marmol']-=50;
			$madera = $_SESSION['suministros']['madera'];
			$marmol = $_SESSION['suministros']['marmol'];
		}
	}

	//Construimos cantera
	if (isset($_POST['cantera_x'])) {
		//Mirar si hay recursos
		if ( ($madera >= 50) && ($marmol >= 200)) {
			//A construir
			$_SESSION['edificios']['canteras']++;

			//Decrementar stock
			$_SESSION['suministros']['madera']-=50;
			$_SESSION['suministros']['marmol']-=200;
			$madera = $_SESSION['suministros']['madera'];
			$marmol = $_SESSION['suministros']['marmol'];
		}
	}
//Construimos huerto
if (isset($_POST['huerto_x'])) {
	//Mirar si hay recursos
	if ( ($madera >= 50) && ($comida >= 200)) {
		//A construir
		$_SESSION['edificios']['huertos']++;
		//Decrementar stock
		$_SESSION['suministros']['madera']-=50;
		$_SESSION['suministros']['comida']-=200;
		$madera = $_SESSION['suministros']['madera'];
		$comida = $_SESSION['suministros']['comida'];
	}
}
//Construimos mercado
if (isset($_POST['mercado_x'])) {
	//Mirar si hay recursos
	if ( ($madera >= 50) && ($marmol >= 50) && ($oro >= 100)) {
		//A construir
		$_SESSION['edificios']['mercados']++;
		//Decrementar stock
			$_SESSION['suministros']['madera']-=50;
			$_SESSION['suministros']['marmol']-=50;
			$_SESSION['suministros']['oro']-=100;
		$madera = $_SESSION['suministros']['madera'];
		$oro = $_SESSION['suministros']['oro'];
		$marmol = $_SESSION['suministros']['marmol'];
	}
}

	//Al mover las variables de los edificios abajo del todo podemos acortar el código
	//ya que elimino una línea de cada apartado del edificio a construir
	$num_cuarteles = $_SESSION['edificios']['cuarteles'];
	$num_templos = $_SESSION['edificios']['templos'];
	$num_aserraderos = $_SESSION['edificios']['aserraderos'];
	$num_canteras = $_SESSION['edificios']['canteras'];
	$num_huertos = $_SESSION['edificios']['huertos'];
	$num_mercados = $_SESSION['edificios']['mercados'];


?>



<section>

	<h3 id ="oro"><?php print $oro; ?></h3>
	<h3 id="madera"><?php print "&nbsp;&nbsp;&nbsp;".$madera; ?></h3>
	<h3 id="comida"><?php print "&nbsp;&nbsp;&nbsp;&nbsp;".$comida; ?></h3>
	<h3 id="marmol"><?php print "&nbsp;&nbsp;&nbsp;".$marmol."&nbsp;&nbsp;"; ?></h3>


	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

	    	<input type="image" src="imgs/crear_templo.gif" name="templo" value="templo">
	    	<input type="image" src="imgs/crear_cuartel.gif" name="cuartel" value="cuartel">	  
	    	<input type="image" src="imgs/crear_aserradero.gif" name="aserradero" value="aserradero">	  
	    	<input type="image" src="imgs/crear_cantera.gif" name="cantera" value="cantera">	  
			<input type="image"	src="imgs/crear_huerto.gif" name="huerto" value="huerto">
			<input type="image"	src="imgs/crear_mercado.gif" name="mercado" value="mercado">


	</form>
</section>

<?php
	print "<p>";
	print "<span>Templos: $num_templos</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Cuarteles: $num_cuarteles</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Aserraderos: $num_aserraderos</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Canteras: $num_canteras</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Huertos: $num_huertos</span>&nbsp;&nbsp;&nbsp;";
	print "<span>Mercados: $num_mercados</span>&nbsp;&nbsp;&nbsp;";
	print "</p>";

?>



<?php
	//PIE DE PÁGINA
	include('pie.php');
?>