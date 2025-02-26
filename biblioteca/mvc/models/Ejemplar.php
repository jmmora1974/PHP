<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Ejemplar extends Model{
	/** @var string $table nombre de la tabla en la bdd */
	protected  static $table = "ejemplares";
	
}