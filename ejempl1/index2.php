
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de ejemplo PHP">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejemplo PHP</title>
	<base href="./" target="_blank">
	
</head>

<body>


		<h1>Ejemplo </h1>
		
   <form>
            <input type="text" placeholder="Nombre" name="nombre"<?php if (isset($_REQUEST['nombre']) && $_REQUEST['nombre'] != ''): ?> value="<?php echo $_REQUEST['nombre']; ?>"<?php endif; ?>>
            <input type="number" placeholder="Edad" name="edad"<?php if (isset($_REQUEST['edad']) && $_REQUEST['edad'] != ''): ?> value="<?php echo $_REQUEST['edad']; ?>"<?php endif; ?>>
            <input type="submit">
        </form>
</body>

</html>