<?php

#[AllowDynamicProperties]
class Libro{
	
	//NO se indica las PROPIEDADES , se crearan
	//dinamicamente en el metodoo fetch_object() a partir de
	//los campos recuperados en la consulta
	
	//No seindica el CONSTRUCTOr, da problemas con el fetc_object()
	
	//Se implementa el metodo to_String solo para demostrar que funciona
	public function __toString(){
		return "$this->titulo, de $this->autor. Editoria $this->editorial.";
		
	}
}
