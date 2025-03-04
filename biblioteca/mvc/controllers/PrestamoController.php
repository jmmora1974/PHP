<?php
use http\Message;

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
		
		
		$prestamos= V_prestamo::all(); // recupera los prestamoes del prestamo
		
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
		
		//recupera los prestamoes del prestamo
		$prestamoes= $prestamo->hasMany('Prestamo');
		
		// carga la vista y le pasa el prestamo recuperado
		return view ('prestamo/show',['prestamo'=>$prestamo,'prestamoes'=>$prestamoes]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo prestamo
	 * @return ViewResponse
	 */
	public function create(){
		
		//$prestamo = Prestamo::findOrFail($idprestamo,'No se encontró el prestamo.');
		
		//retorna una ViewResponse con la vista con el formulario de creacion
		return view('Prestamo/create');
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
				
				//guarda el prestamo en la base de datos a partir de los datosPOST
				$prestamo = Prestamo::create(request()->posts()); 
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del prestamo $prestamo->id correcto.");
				
				//redirecciona a los detalles del nuevo prestamo
				return redirect("/Prestamo/edit/$prestamo->idprestamo");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el prestamo del prestamo ".$prestamo->titulo;
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un prestamo con ese <b>ID</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de prestamo
				return redirect("/Prestamo/create/$prestamo->id");
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
	public function destroy(int $id=-1){

		//Recupera el elemplar de la BDD			
		$prestamo	=Prestamo::findOrFail($id, "No se encontró el prestamo.");
		$prestamo=Prestamo::findOrFail($prestamo->idprestamo,"No se ha encontrado el prestamo");
		//Si hay prestamos, no permitimos el borrado
		try{
			if($prestamo->hasAny('Prestamo','idprestamo')){
				throw new Exception("No se puede borrar el prestamo mientras está prestado.");
				return redirect("/Prestamo/edit/$prestamo->idprestamo");
			}
		} catch (Exception $e){
						Session::error($e->getMessage());
			
				return redirect("/Prestamo/edit/$prestamo->idprestamo");
		}	
			//intenta borrar el prestamo
		try{
				$prestamo->deleteObject();
				Session::success("Se ha borrado el prestamo $prestamo->id de prestamo $prestamo->titulo.");
				return redirect("/Prestamo/edit/$prestamo->idprestamo");
				//si se produce un error en la operació con la bdd..
		} catch (Exception $e){
			
			Session::error("No se pudo borrar el prestamo $prestamo->id de  $prestamo->titulo.");
			
			
			return redirect("/Prestamo/edit/$prestamo->idprestamo");
		}
		
	}
	
}
