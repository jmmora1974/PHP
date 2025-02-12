<?php 
//pone el header de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function cabecera(string $titulo='', string $subtitulo=''){ ?>
	
	<header class="flex-container header">
		<figure id="logo" class="text-start  logo">
			<a href="index.php" class="flex1" target="_self"><img src="./images/logomitravel.png" alt="Logo Mitravel"
					style="width:50px;height:50px"></a>
		</figure>
		<hgroup class="flex1">
			<h1><?=$titulo ?></h1>
			<h2><?= $subtitulo ?></h2>
		</hgroup>
		<div class="search-container">
			<form action="/action_page.php">
				<input type="text" placeholder="Search.." name="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<form id="formlogin" class="flex1 text-end" action="/action_page.php">
			<fieldset>
				<input type="text" id="usuariologin" placeholder="Escribe tu usuario" name="usuario">
				<input type="password" id="pwdlogin" placeholder="Entra la contraseña" name="pswd">
			</fieldset>
			<fieldset>
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
				<button type="submit" class="btn-login">Login</button>
				<p>Registrate <a href="register.php" target="_self">aquí</a></p>
			</fieldset>
		</form>
	</header>
	<?php }
	
	
	
// pone el menu de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function menu(string $actual = 'ini'){ ?>
	
	<nav class=" topnav ">
		<menu>
			<li><a href="#" <?= $actual =='ini' ? 'clas="active"':''?> target="_self">Inicio</a></li>
			<li><a href="recomendaciones.php" <?= $actual =='recomendaciones' ? 'clas="active"':''?> target="_self">Recomendaciones</a></li>
			<li><a href="contacto.php" <?= $actual =='contacto' ? 'clas="active"':''?> target="_self">Contacto</a></li>
			<li><a href="about.php" <?= $actual =='about' ? 'clas="active"':''?> target="_self">Sobre nosotros</a></li>
		</menu>
	</nav>
	
<?php } 

//pone el migas de la pagina
function migas(array $entradas= NULL){?>
	if($entradas){
		echo "\t\t<ul class='migas'>\n";
		foreach ($entradas as $pagina=>$enlace)
			echo "\t\t\t<li><a href='$enlace>$pagina</a></li>\n";
		echo "\t\t</ul>\n";
	}
}

<?php } 

//pone el mapa web
function mapaweb(){?>
	<div>
			<h5 id="titulomapa"> Mapa web </h5>
	</div>
	<div id="mapaweb">
	
	<ul class="responsive">
	
	<li><a href="./index.php" target="_self"><strong><u>Portada</u></strong></a></li>
	
	<li><a href="./index.php#divciudad" target="_self">Localizacion</a></li>
	<li><a href="./index.php#formularios" target="_self">Actividades</a></li>
	<li><a href="./index.php#contenedormapa" target="_self">Mapa</a></li>
	<li><a href="./index.php#listado" target="_self">Listado lugares</a></li>
	<li><a href="./index.php#listado" target="_self">Detalles lugar</a></li>
	<li><a href="./index.php#agenda" target="_self">Agenda</a></li>
	</ul>
	<ul class="responsive">
	<li><a href="./recomendaciones.php" target="_self"><strong><u>Recomendaciones</u></strong></a></li>
	<li><a href="./recomendaciones.php#carrusel" target="_self">Excursiones 4x4</a></li>
	<li><a href="./recomendaciones.php#video1" target="_self">Circuito nocturno</a></li>
	</ul>
	<ul class="responsive">
	<li><a href="./contacto.php" target="_self"><strong><u>Contacto</u></strong></a></li>
	<li>Preguntas frecuentes</li>
	<li>Consejos</li>
	</ul>
	<ul class="responsive">
	<li><a href="./about.php" target="_self"><strong><u>Sobre nosotros</u></strong></a></li>
	<li>Aviso legal</li>
	<li><a href="https://www.w3.org/TR/WCAG10/" target="_blank">Accesibilidad</a></li>
	</ul>
	
	
	</div>
<?php } 

// Pone el chat de setrvicio al atencion usurio
function chatservice(){?>
	<div id="chat-container">
	<div id="title_bar">
	<button id="buttonchat">-</button>
	<label>Soporte en linea</label>
	
	</div>
	<div id="chat-messages">Tienes alguna consulta?</div>
	<form id="chat-form">
	
	<div id="box">
	</div>
	<input type="text" id="chat-input" placeholder="Escribe tu mensaje aquí...">
	<button type="submit">Enviar</button>
	</form>
</div>
<?php } 

//pone el pie de la pagina
function piedepagina(string $autor =''){?>
<footer>
<div class="w3-container w3-teal">
	<details>

			<summary>
				<b>Mitravel®</b>. Web para planificar tus aventuras.
				 <p>@author:<?=$autor?></p>
				<i class="fa fa-copyright" aria-hidden="true"></i><i class="fa fa-envelope-o" aria-hidden="true"></i>

			</summary>

		</details>
	
	</div>
</footer>
<?php  }