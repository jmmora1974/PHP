<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Tema extends Model{
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['tema','descripcion'];
	
	
}