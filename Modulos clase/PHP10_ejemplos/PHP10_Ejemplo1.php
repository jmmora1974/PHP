

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 10 Ejemplo 1">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 10 Ejemplo 1</title>
    <base href="./" target="_blank">
    
    </head>
    
    <body>
    <h1>PHP 10 Ejemplo 1</h1>
    <p></p>
    <?php 
    include 'Coche.php';
    
    //Creamos nuevo coche
    $coche= new Coche('Opel','Monterey');
    $coche->avanzar(100);
    echo $coche;
    echo "<br>";
    
    
    //Creamos nuevo coche
    $coche1= new Coche('Peugeot','308',514);
    $coche1->avanzar(100);
    echo $coche;
    echo "<br>";
    
    
    include 'Perro.php';
    //Cramos nuevo perrro
    $perro1 = new Perro ("Toby","Dalmata",10);
    $perro1->engordar(5);
    $perro1->ladrar();
    echo $perro1;
    
    
    
    
   ?> 


</body>


</html>
