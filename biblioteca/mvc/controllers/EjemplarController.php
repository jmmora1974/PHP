<?php


/**
 * EjemplarController
 *
 * Operaciones con los  ejemplares de libro
 *
 * @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
 */

class EjemplarController extends Controller{
	
	/**
	 * Mérodo por defecto
	 *
	 * Redirige al método list() de este mismo controlado.
	 *
	 * @return ViewResponse
	 */
	public function index(){
		if( Login::role('ROLE_LIBRARIAN' ))// autorización(solo bibliotecarios)
				return $this->list();
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
	}
	
	/**
	 * Listado de libros
	 *
	 * @return ViewResponse
	 *
	 */
	public function list(){
		
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			
			$ejemplares= Ejemplar::all(); // recupera los ejemplares del libro
			//	carga la vista que los muestra
			return view('ejemplar/list',['ejemplares'=>$ejemplares]);
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
	}
	
	/**
	 * Muestra los detalles del un libro
	 * @param int $id identificador del libro a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
	  	if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			// Recupera el libro
			$libro = Ejemplar::findOrFail($id, 'No se encontró el ejemplar indicado'); //tb comprueba si no le ha llegado el ID
			
			//recupera los ejemplares del libro
			$ejemplares= $libro->hasMany('Ejemplar');
			
			// carga la vista y le pasa el libro recuperado
			return view ('ejemplar/show',['libro'=>$libro,'ejemplares'=>$ejemplares]);
	  	}
	  	//Si no es bibliotecario, redirige a la home
	  	return redirect('/');
		
	}
	
	/**
	 * Muestra el formulario de nuevo ejemplar
	 * @return ViewResponse
	 */
	public function create(int $idlibro=-1){
		
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			
			$libro = Libro::findOrFail($idlibro,'No se encontró el libro.');
		
			//retorna una ViewResponse con la vista con el formulario de creacion
			return view('Ejemplar/create',['libro'=>$libro]);
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');

	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');
			$ejemplar=new Ejemplar(); //crea el nuevo ejemplar
			
		//OPCION AUTOMATICA
			try{
				
				//guarda el libro en la base de datos a partir de los datosPOST
				$ejemplar->saneate(); //sanea las entradas.
				$ejemplar = Ejemplar::create(request()->posts()); 
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del ejemplar $ejemplar->id correcto.");
				
				//redirecciona a los detalles del nuevo libro
				return redirect("/Libro/edit/$ejemplar->idlibro");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el ejemplar del libro ".$libro->titulo;
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un ejemplar con ese <b>ID</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de libro
				return redirect("/Ejemplar/create/$libro->id");
			}
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
		

	}
	
	/**
	 * Muestra el formulario de confirmación de eliminación
	 *
	 * @param int $id identificador único del libro a eliminar
	 *
	 * @return ViewResponse
	 */
	public function delete(int $id=0){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			$libro = Libro::findOrFail($id, "No existe el libro.");
			
			return view('libro/delete',['libro'=> $libro]);
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
	
	}
	
	/** Elimina el ejemplar de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(int $id=-1){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			//Recupera el elemplar de la BDD			
			$ejemplar	=Ejemplar::findOrFail($id, "No se encontró el ejemplar.");
			$libro=Libro::findOrFail($ejemplar->idlibro,"No se ha encontrado el libro");
			//Si hay prestamos, no permitimos el borrado
			try{
				if($ejemplar->hasAny('Prestamo','idejemplar')){
					throw new Exception("No se puede borrar el ejemplar mientras está prestado.");
					return redirect("/Libro/edit/$ejemplar->idlibro");
				}
			} catch (Exception $e){
							Session::error($e->getMessage());
				
					return redirect("/Libro/edit/$ejemplar->idlibro");
			}	
				//intenta borrar el ejemplar
			try{
					$ejemplar->deleteObject();
					Session::success("Se ha borrado el ejemplar $ejemplar->id de libro $libro->titulo.");
					return redirect("/Libro/edit/$ejemplar->idlibro");
					//si se produce un error en la operació con la bdd..
			} catch (Exception $e){
				
				Session::error("No se pudo borrar el ejemplar $ejemplar->id de  $libro->titulo.");
				
				
				return redirect("/Libro/edit/$ejemplar->idlibro");
			}
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
		
	}
	
	/**
	 * Muestra el formulario de edición del ejemplar del libro
	 *
	 * @param int $id el ID único del ejemplar a editar
	 *
	 * @return ViewResponse
	 *
	 */
	public function edit(int $id=0){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			// busca el libro con ese ID
			$ejemplar = Ejemplar::findOrFail($id,'No se encontró el ejemplar.');
			
			//recupera los ejemplares del libro
			 $libro= $ejemplar->belongsTo('Libro');
			
			//retorna una ViewResponse con la vista con el formulario de edición
			 return view('ejemplar/edit',['ejemplar'=>$ejemplar, 'libro'=>$libro]);
	
		}
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	 */
	public function update(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
				
				$id = intval(request()->post('id')); // recuperar el id via POST
				
				
				//Con la actualización a 1.8.0 ya se puede recuperar el formulario y tratarlo directamente
				/*
				 $libro = Libro::findOrFail($id,"No se ha encontrado el libro.");
				 
				 //recuperar el resto de campos
				 $libro->isbn	= request()->post('isbn');
				 $libro->titulo	= request()->post('isbn');
				 $libro->editorial	= request()->post('isbn');
				 $libro->autor	= request()->post('isbn');
				 $libro->idioma	= request()->post('isbn');
				 $libro->edicion	= request()->post('isbn');
				 $libro->anyo	= request()->post('isbn');
				 $libro->edadrecomendada	= request()->post('isbn');
				 $libro->paginas	= request()->post('isbn');
				 $libro->caracteristicas = request()->post('isbn');
				 $libro->sinopsis	= request()->post('isbn');
				 */
				$libro= request()->post('idlibro');
				//intenta actualizar el libro
				try{
					//$libro->update(); No es necesario en la 1.8.0
					// ya el metodo create ya actualiza si manda el 2ºparametro
					$ejemplar->saneate(); //sanea las entradas.
					$ejemplar= Ejemplar::create(request()->posts() ,$id);
					
					Session::success("Actualización del ejemplar $ejemplar->id del libro $ejemplar->idlibro correcta.");
					return redirect("/Libro/edit/$ejemplar->idlibro");
					
					// Si se produce un error al guardar el libro..
				}catch (SQLException $e){
					// prepara el mensaje de error
					$mensaje = "No se pudo actualizar el ejemplar";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un ejemplar con ese <b>ID</b>.";
						Session::error($mensaje);
						
						if(DEBUG)
							throw new SQLException($e->getMessage());
							
							return redirect("/Libro/edit/$ejemplar->idlibro");
				}
			}
		
		//Si no es bibliotecario, redirige a la home
		return redirect('/');
	}
}
