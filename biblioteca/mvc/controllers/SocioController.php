<?php
/**
* SocioController
* 
* Operaciones con los socios
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class SocioController extends Controller{
	
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
	 * Listado de socios
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(){
	  //	$socios = Socio::orderBy();  //sale ordenado, sin ejemplares
	 
		$socios= socio::all(); // recupera los socios junto la información extra (prestamos)
	
		//	carga la vista que los muestra
		return view('socio/list',['socios'=>$socios]);
	}
	
	/**
	 * Muestra los detalles del un socio
	 * @param int $id identificador del socio a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
		
		$socio = V_socio::findOrFail($id, 'No se enontró el socio indicado'); //tb comprueba si no le ha llegado el ID
		
		//recupera los prestamos del socio
		$prestamos= $socio->hasMany('V_prestamo','idsocio','id'); //OK
		rsort( $prestamos);
		
		// carga la vista y le pasa el socio recuperado
		return view ('socio/show',['socio'=>$socio, 'prestamos'=>$prestamos]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo socio
	 * @return ViewResponse
	 */
	public function create(){
		return view('socio/create');
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
		$socio=new Socio(); //crea el nuevo socio
		
	//OPCION AUTOMATICA
			try{
				//guarda el socio en la base de datos a partir de los datosPOST
				$socio = Socio::create(request()->posts()); //mo es necesario en la  1.8.0
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del socio $socio->nombre $socio->apellido correcto.");
				
				//redirecciona a los detalles del nuevo socio
				return redirect("/Socio/show/$socio->id");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el socio $socio->nombre $socio->apellidos.";
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un socio con ese <b>DNI</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de socio
				return redirect("/Socio/create");
			}
	
	}
	
	/** 
	 * Muestra el formulario de edición del socio
	 * 
	 * @param int $id el ID único del socio a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		
		// busca el socio con ese ID
		$socio = Socio::findOrFail($id,'No se encontró el socio.');
		
		//recupera los prestamos del socio
		$prestamos= $socio->hasMany('Prestamo');
		
		//retorna una ViewResponse con la vista con el formulario de edición
		return view('socio/edit',['socio'=>$socio,'prestamos'=>$prestamos]);
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		
		if(!request()->has('actualizar')) //si no llega el formulario ...
			throw new FormException ('No se recibieron datos');
		
		$id = intval(request()->post('id')); // recuperar el id via POST
	
	
		//intenta actualizar el socio
		try{
			//$socio->update(); No es necesario en la 1.8.0 
			// ya el metodo create ya actualiza si manda el 2ºparametro
			$socio= Socio::create(request()->posts() ,$id);
			
			Session::success("Actualización del socio $socio->nombre  $socio->apellidos correcta.");
			return redirect("/Socio/edit/$id");
			
		// Si se produce un error al guardar el socio..
		}catch (SQLException $e){
			// prepara el mensaje de error
			$mensaje = "No se pudo actualizar el socio";
			
		if(str_contains($e->errorMessage(),'Duplicate entry'))
				$mensaje.="<br>Ya existe un socio con ese <b>DNI</b>.";
			Session::error($mensaje);
			
			if(DEBUG)
				throw new SQLException($e->getMessage());
			
				return redirect("/Socio/edit/$id");
		}
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del socio a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		
		$socio = Socio::findOrFail($id, "No existe el socio.");
		
		return view('socio/delete',['socio'=> $socio]);
	}
	
	/** Elimina el socio de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$socio	=Socio::findOrFail($id);
			
			//si el socio tiene prestamos, no permitiremos su borrado
			//mas adelante ocultaeremos el boton de "borrar" en estos casos 
			// para que no el usuario no llegue al formulario de confirmación
			if($socio->hasAny('Prestamo'))
				throw new Exception("No se puede borrar el socio mientras tenga prestamos.");
			
				//intenta borrar el socio
				try{
					$socio->deleteObject();
					Session::success("Se ha borrado el socio $socio->nombre  $socio->apellidos.");
					return redirect("/Socio/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el socio $socio->nombre  $socio->apellidos.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Socio/delete/$id");
				}
	}
}	
	 
