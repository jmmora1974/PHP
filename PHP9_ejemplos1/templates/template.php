<?php 
//pone el header de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function cabecera(string $titulo='', string $subtitulo=''){ ?>
	<header>
		<h1><?=$titulo ?></h1>
		<h2><?= $subtitulo ?></h2>
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
function pi(string $autor =''){?>
<footer>
	<p><?=$autor?></p>
</footer>
<?php  }