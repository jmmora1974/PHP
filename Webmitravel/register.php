<?php require 'templates/template.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="keywords" content="HTML, CSS, JavaScript">
  <meta name="description"
    content="Web de busqueda de aventuras, eventos, actividades, que hacer, what to do, planificador de actividades, agenda.">
  <meta name="author" content="Jose Miguel Mora Perez">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- frameworks predefinidos..-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- estilo propio.-->
  <link rel="stylesheet" href="./css/estilo.css">
  <title>Mitravel</title>
  <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
  <base href="./" target="_blank">
</head>

<body>

<?php
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('ini');
	?>
	
  <main>
    <div class="containerRegristo">
      <form id="formRegister" target="_self">
        <fieldset>
          <div id="divavatar" class="text-start flex-container">
            <div class="flex1">
              <img id="avatar" src="./images/perro.png" alt="foto perfil" style="width:100px;height:100px">
              Subir foto...
              <input type="file" class="flex1 text-start">
              <input type="button" id="btnAvatar" class="btn btn-reset warning" value="Cambiar avatar">
            </div>
            <div class="flex4">
              <label for="fuser">Usuario</label>
              <input type="text" id="fuser" name="usuario valid" minlength="4" maxlength="8" class="textRegistro"
                pattern="^[a-zA-Z]\w{2,7}$" placeholder="Escriba su usuario.." required autofocus>

              <label for="fcontrasena">Contraseña:</label>
              <input type="password" id="fcontrasena" name="contrasena" minlength="6" maxlength="12"
                class="textRegistro" placeholder="Escriba su contraseña.." onkeyup="comprobarContrasenyas()" required>

              <label for="fcontrasena2">Contraseña:</label>
              <input type="password" id="fcontrasena2" inlength="6" maxlength="12" name="contrasena2 valid"
                onkeyup="comprobarContrasenyas()" class="textRegistro" placeholder="Repita su contraseña.." required>
              <span id="infoContra"></span>
            </div>
          </div>


        </fieldset>
        <fieldset>
          <label for="fnombre">Nombre</label>
          <input type="text" id="fnombre" name="nombre" class="textRegistro" 
            placeholder="Escriba su nombre.." required>

          <label for="fapellidos">Apellido</label>
          <input type="text" id="fapellidos" name="apellidos" class="textRegistro"
            placeholder="Escriba sus apellidos..">
        </fieldset>
        <fieldset>
          <label for="fnif">NIF</label>
          <input type="text" id="fnif" name="nif" class="textRegistro" placeholder="Escriba su NIF/NIE.." required>

          <label for="fsexo">Sexo</label>
          <select id="fsexo" name="sexo">
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            <option value="Aveces">Aveces</option>
            <option value="Cuando se puede">Cuando se puede</option>
          </select>

          <label for="fmail">Mail</label>
          <input type="email" id="fmail" name="mail" class="textRegistro" placeholder="Escriba su mail.." required>

          <label for="fnacimiento">Fecha de nacimiento</label>
          <input type="date" id="fnacimiento" name="nacimiento" class="textRegistro" required>

          <label for="fpoblacion">Población</label>
          <input type="text" id="fpoblacion" name="poblacion" class="textRegistro"
            placeholder="Escriba sus poblacion..">

          <label for="country">Pais</label>
          <select id="country" name="country">
            <option value="España">España</option>
            <option value="Catalunya">Catalunya</option>
            <option value="Andorra">Andorra</option>
            <option value="Portugal">Portugal</option>
          </select>
          <label for="finfo">Deseas recibir promociones de nuestra web?
            <input type="checkbox" id="finfo" name="finfo" class="textRegistro"></label>

        </fieldset>
        <input id="btnEnviarReg" type="submit" class="valid" name="enviar" value="Enviar" disabled>
        <input id="btnResetReg" type="submit" class="btn btn-reset" onclick="formRegister.reset()" value="Reset">
      </form>
    </div>
    <div class="inferior">
				<?php chatservice();?>

			</div>

			 
			
			<div class="clearfix"></div>
		
			
			<?php mapaweb();?>
	</main>
		<?php piedepagina ('Jose Miguel Mora Perez')?>
  

  <script>
    const contra1 = document.getElementById("fcontrasena");
    const contra2 = document.getElementById("fcontrasena2");
    const nombrereg = document.getElementById("fnombre");
    const apellidosreg = document.getElementById("fapellidos");

    function comprobarContrasenyas() {
      if (contra1.value == contra2.value) {
        document.getElementById("btnEnviarReg").disabled = false;
        document.getElementById("infoContra").innerHTML = "Las contraseñas coinciden";
        infoContra.innerHTML = "Las contraseñas coinciden";
        infoContra.innerHTMLText = "Las contraseñas coinciden txt";
        infoContra.style.color = "green";

      } else {
        btnEnviarReg.disabled = true;
        contra1.title = "Las contraseñas han de tener la misma longitud";
        contra2.title = "Las contraseñas han de tener la misma longitud";
        infoContra.innerHTML = "Las contraseñas han de tener la misma longitud";
        infoContra.style.color = "red";
        document.getElementById("infoContra").innerHTMLText = "Las contraseñas han de tener la misma longitud";
      };
      contra1.addEventListener("keyup", comprobarContrasenyas());
      contra2.addEventListener("keyup", comprobarContrasenyas());
    }

    nombrereg.addEventListener("keyup", () => {
     nombrereg.value=nombrereg.value.toUpperCase();
    });

    apellidosreg.addEventListener("keyup", () => {
      apellidosreg.value=apellidosreg.value.toUpperCase();
    });

    

    fcontrasena2.addEventListener("keyup", () => {
      logElement.innerText = `Name: ${inputElement.value}`;
    });

 

  </script>
<script src="./js/chatservice.js"></script>
</body>

</html>