<?php
use http\Message;

/**
 * EjemplarController
 *
 * Operaciones con los  ejemplares de libro
 *
 * @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
 */
#[AllowDynamicProperties] 
class ContactoController extends Controller{
	
	/**
	 * Mérodo por defecto
	 *
	 * Redirige al método list() de este mismo controlado.
	 *
	 * @return ViewResponse
	 */
	public function index(){
		return view('contacto');
	}
	
	/**
	 * Envía el email al administrador de la aplicacion
	 * 
	 * @return RedirectResponse
	 */
	public function send(){
		
		if (empty(request()->post('enviar')))
			throw new FormException('No se recibió el formulario de contacto');
		
		//toma los datos del formulario
			$from= request()->post('email');
			$name= request()->post('nombre');
			$subject= request()->post('asunto');
			$message= request()->post('mensaje');
			
			//intenta prepara y enviar el email al administrador
			// cuyo email esta configurado en el config
			try{
				$email=new Email(ADMIN_EMAIL, $from, $name, $subject, $message);
				$email->send();
				
				//flasehea el mensaje de exito y redirecciona a la portada
				Session::success("Mensaje enviado, en breve recibirás una respuesta.");
				return redirect('/');
				
			}catch (EmailException $e){
				Session::error('No se pudo enviar el email.');
				
				if(DEBUG)
					throw new Exception ($e->getMessage());
				
				return redirect("/Contacto");
					
			}
	}
	
		
}
