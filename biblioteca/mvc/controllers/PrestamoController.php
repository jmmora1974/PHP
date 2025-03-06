<?php

/**
 * PrestamoController
 *
 * Operaciones con los  prestamoes de prestamo
 *
 * @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
 */

class PrestamoController extends Controller{
	
	/**
	 * Mérodo por defecto
	 *
	 * Redirige al método list() de este mismo controlado.
	 *
	 * @return ViewResponse
	 */
	public function index(){
		return $this->list();
	}
	
	/**
	 * Listado de prestamos
	 *
	 * @return ViewResponse
	 *
	 */
	public function list(){
		
		
		$prestamos= V_prestamo::orderBy('prestamo','DESC'); // recupera los prestamoes del prestamo
		
		//	carga la vista que los muestra
		return view('prestamo/list',['prestamos'=>$prestamos]);
	}
	
	/**
	 * Muestra los detalles del un prestamo
	 * @param int $id identificador del prestamo a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
		
		// Recupera el prestamo
		$prestamo = Prestamo::findOrFail($id, 'No se encontró el prestamo indicado'); //tb comprueba si no le ha llegado el ID
		
		//recupera los prestamos del socio
		$prestamos= $prestamo->hasMany('Prestamo');
		
		// carga la vista y le pasa el prestamo recuperado
		return view ('prestamo/show',['prestamo'=>$prestamo,'prestamoes'=>$prestamos]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo prestamo
	 * @return ViewResponse
	 */
	public function create(int $id=0){
		
		
		if ($id==0){
			$socio=[];
		} else{
			// Recupera el prestamo
			$socio = Socio::findOrFail($id, 'No se encontró el socio indicado'); //tb comprueba si no le ha llegado el ID
		}
		
		//retorna una ViewResponse con la vista con el formulario de creacion
		return view('Prestamo/create',['socio'=>$socio]);
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		//Comprueba que la petición venga del formulario
		if(!request()->has('guardar'))
			throw new FormException('No se recibió el formulario');
		$prestamo=new Prestamo(); //crea el nuevo prestamo
		
	//OPCION AUTOMATICA
			try{
				$prestamo->idsocio=intval(request()->post('idsocio'));
				$prestamo->idejemplar=intval(request()->post('idejemplar'));
				$prestamo->limite= request()->post('limite');
			
				//guarda el prestamo en la base de datos a partir de los datosPOST
				//$prestamo = Prestamo::create($prestamo);
				$prestamo->save();
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del prestamo $prestamo->id  para el socio $prestamo->idsocio correcto.");
				
				//redirecciona a los detalles del nuevo prestamo
				return redirect("/Socio/show/$prestamo->idsocio");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el prestamo del socio ".$prestamo->id;
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un prestamo con ese <b>ID</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de prestamo
				return redirect("/Prestamo/create/$prestamo->idsocio");
			}

	}
	
	/**
	 * Muestra el formulario de confirmación de eliminación
	 *
	 * @param int $id identificador único del prestamo a eliminar
	 *
	 * @return ViewResponse
	 */
	public function delete(int $id=0){
		
		$prestamo = Prestamo::findOrFail($id, "No existe el prestamo.");
		
		return view('prestamo/delete',['prestamo'=> $prestamo]);
	}
	
	/** Elimina el prestamo de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		$id=intval(request()->post('id'));
		//Recupera el elemplar de la BDD			
		//$prestamo	=Prestamo::findOrFail($id, "No se encontró el prestamo.");
		$prestamo=Prestamo::findOrFail($id,"No se ha encontrado el prestamo");
		
			//intenta borrar el prestamo
		try{
				$prestamo->deleteObject();
				Session::success("Se ha borrado el prestamo $prestamo->id de prestamo $prestamo->titulo.");
				return redirect("/Prestamo");
				//si se produce un error en la operació con la bdd..
		} catch (Exception $e){
			
			Session::error("No se pudo borrar el prestamo $prestamo->id de  $prestamo->titulo.");
			
			
			return redirect("/Prestamo/edit/$prestamo->idprestamo");
		}
		
	}
	
	/**
	 * Realiza el proceso de devolucion de un libro
	 *
	 * @param int $id identificador único del prestamo a procesar
	 *
	 * @return ViewResponse
	 */
	public function devolucion(int $id=0){
		
		$prestamo = Prestamo::findOrFail($id, "No existe el prestamo.");
		$date = new DateTime();
		 
		$prestamo->devolucion=$date->format('Y-m-d');
	
		//intenta actualizar el prestamo
		try{
			// ya el metodo create ya actualiza si manda el 2ºparametro
			$prestamonuevo= $prestamo->update();
			
			Session::success("Actualización del prestamo $prestamo->id para el socio $prestamo->idsocio correcta.");
			return redirect("/Socio/show/$prestamo->idsocio");
			
			// Si se produce un error al guardar el libro..
		}catch (SQLException $e){
			// prepara el mensaje de error
			$mensaje = "No se pudo actualizar el prestamo";
			
			if(str_contains($e->errorMessage(),'Duplicate entry'))
				$mensaje.="<br>Ya existe un prestamo con ese <b>ID</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
					
					return redirect("/Socio/show/$prestamo->idsocio");
		}
		
		
	}
	
	/**
	 * Realiza el proceso de incidencia de un libro
	 *
	 * @param int $id identificador único del prestamo a procesar
	 *
	 * @return ViewResponse
	 */
	public function incidencia(int $id=0){
		
		$prestamo = Prestamo::findOrFail($id, "No existe el prestamo.");
		
		//	carga la vista que los muestra
		return view('prestamo/incidencia',['prestamo'=>$prestamo]);
		
	}
	
	/**
	 * Realiza el guardado de incidencia de un libro
	 *
	 
	 * @return ViewResponse
	 */
	public function guardaincidencia(){
		//Comprueba que la petición venga del formulario
		if(!request()->has('guardar'))
			throw new FormException('No se recibió el formulario');
			
			
			try{
				$id=intval(request()->post('id'));
				$prestamo = Prestamo::findOrFail($id, "No existe el prestamo.");
			
				$prestamo->incidencia= request()->post('incidencia');
				
				//guarda el prestamo en la base de datos a partir de los datosPOST
			
				$prestamo->update();
				
			
			Session::success("Actualización del prestamo $prestamo->id para el socio $prestamo->idsocio correcta.");
			return redirect("/Socio/show/$prestamo->idsocio");
			
			// Si se produce un error al guardar el libro..
		}catch (SQLException $e){
			// prepara el mensaje de error
			$mensaje = "No se pudo actualizar el prestamo";
			
			if(str_contains($e->errorMessage(),'Duplicate entry'))
				$mensaje.="<br>Ya existe un prestamo con ese <b>ID</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
					
					return redirect("/Socio/show/$prestamo->idsocio");
		}
		
		
	}
	/**
	 * Muestra el formulario de ampliación de un prestamo
	 * @return ViewResponse
	 */
	public function ampliar(int $id=0){
		
		
		if ($id==0){
			$prestamo=[];
			$socio=[];
		} else{
			// Recupera el prestamo
			$prestamo = Prestamo::findOrFail($id, 'No se encontró el prestamo indicado'); //tb comprueba si no le ha llegado el ID
			// Recupera el socio
			$socio = Socio::findOrFail($prestamo->idsocio, 'No se encontró el socio indicado');
		}
		
		//retorna una ViewResponse con la vista con el formulario de creacion
		return view('Prestamo/ampliar',['prestamo'=>$prestamo,'socio'=>$socio]);
	}
	
	/**
	 * Muestra el formulario de ampliación de un prestamo
	 * @return ViewResponse
	 */
	public function ampliacion(int $id=0){
		//Comprueba que la petición venga del formulario
		if(!request()->has('ampliar'))
			throw new FormException('No se recibió el formulario');
		$prestamo=new Prestamo();
					
			try{
				$prestamo->id=intval(request()->post('id'));
				$prestamo->idsocio=intval(request()->post('idsocio'));
				$prestamo->idejemplar=intval(request()->post('idejemplar'));
				$prestamo->limite= request()->post('limite');
				
				//guarda el prestamo en la base de datos a partir de los datosPOST
				//$prestamo = Prestamo::create($prestamo);
				$prestamo->update();
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardada ampliación del prestamo $prestamo->id  para el socio $prestamo->idsocio correcto.");
				
				//redirecciona a los detalles del nuevo prestamo
				return redirect("/Socio/show/$prestamo->idsocio");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el prestamo del socio ".$prestamo->id;
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un prestamo con ese <b>ID</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						//regresa al formulario de creación de prestamo
						return redirect("/Prestamo/create/$prestamo->idsocio");
			}
			
	}
	
}
