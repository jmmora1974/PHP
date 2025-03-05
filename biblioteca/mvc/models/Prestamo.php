<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Prestamo extends Model{
	
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['idsocio','idejemplar','limite'];
}