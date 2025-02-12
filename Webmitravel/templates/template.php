<?php 
//pone el header de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function cabecera(string $titulo='', string $subtitulo=''){ ?>
	
	<header class="flex-container header">
		<figure id="logo" class="text-start  logo">
			<a href="index.php" class="flex1" target="_self"><img src="./images/logomitravel.png" alt="Logo Mitravel"
					style="width:100px;height:100px"></a>
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
				<p>Registrate <a href="register.html" target="_self">aquí</a></p>
			</fieldset>
		</form>
	</header>
	<?php }
	
// pone el menu de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function menu(string $actual = 'ini'){ ?>
	<menu>
		<li><a href="#" <?= $actual =='ini' ? 'clas="active"':''?>>Inicio</a></li>
		<li><a href="#" <?= $actual =='recomendaciones' ? 'clas="active"':''?>>Recomendaciones</a></li>
		<li><a href="#" <?= $actual =='contacto' ? 'clas="active"':''?>>Contacto</a></li>
		<li><a href="#" <?= $actual =='about' ? 'clas="active"':''?>>Sobre nosotros</a></li>
	</menu>
<?php } 

//pone el migas de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function migas(array $entradas= NULL){
	if($entradas){
		echo "\t\t<ul class='migas'>\n";
		foreach ($entradas as $pagina=>$enlace)
			echo "\t\t\t<li><a href='$enlace>$pagina</a></li>\n";
		echo "\t\t</ul>\n";
	}
}

//pone el pie de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function pie(string $autor =''){?>
<footer>
	<p><?=$autor?></p>
</footer>
<?php  }