<?php

/** Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones de FastLight.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * Última revisión: 26/02/2025
 */

class User extends Model implements Authenticable{

    use Authorizable; // usa el trait authorizable
    
    
    /** @var array $jsonFields lista de campos JSON que deben convertirse en array PHP. */
    protected static $jsonFields = ['roles'];
    
    
    /** @var array $fillable lista de campos permitidos para asignaciones masivas usando el método create() */
    protected static $fillable = ['displayname', 'email', 'phone', 'password', 'picture'];

    
    /**
     * Retorna un usuario a partir de un teléfono y un email. Lo usaremos
     * en la opción "olvidé mi password".
     * 
     * @param string $phone número de teléfono.
     * @param string $email email.
     * 
     * @return User|NULL el usuario recuperado o null si no existe la combinación de email y teléfono.
     */
    public static function getByPhoneAndMail(
        string $phone,
        string $email
    ):?User{
        
        $consulta = "SELECT *  
                     FROM users  
                     WHERE phone = '$phone' 
                        AND email = '$email' ";
        
        if($usuario = (DB_CLASS)::select($consulta, self::class))
            $usuario->parseJsonFields();
        
        
        return $usuario;
    }
    
            
    // MÉTODOS DE AUTHENTICABLE
    
    /**
     * Método encargado de comprobar que el login es correcto y recuperar el usuario.
     * Permitiremos la identificación por email o teléfono.
     * 
     * @param string $emailOrPhone email o teléfono.
     * @param string $password clave del usuario.
     * 
     * @return User|NULL si la identificación es correcta retorna el usuario, en caso contrario NULL.
     */
    public static function authenticate(
        string $emailOrPhone = '',      // email o teléfono
        string $password = ''           // debe llegar encriptado con MD5
            
    ):?User{
        
        // preparación de la consulta
        $consulta="SELECT *  FROM users
                   WHERE (email='$emailOrPhone' OR phone='$emailOrPhone') 
                   AND password='$password'
                   AND blocked_at IS NULL";
        
        $usuario = (DB_CLASS)::select($consulta, self::class);
        
        if($usuario)
            $usuario->parseJsonFields();
        
        return $usuario;
    }  
    
    /** Metodo que retorna los errores de validación de un Libro,
     *
     * Si no hay errores, retorna un array vacío.
     *
     * @param bool $checkId Indica si se debe hacer la comprobación dobre el campo id (no se hace en un store pero si en un update)
     *
     * @return array El listado de errores de validación
     */
    public function validate(bool $checkId =false):array{
    	$errores =[];
    	
    	//el campo id solamente se comprube en el udate()
    	if($checkId && empty(intval($this->id)))
    		$errores['id']="No se indicó el identificador";
    		
    		    			//displayname: de 1 a 64 caracteres
    			if (empty($this->displayname)||strlen($this->displayname)<1 || strlen($this->displayname)>64)
    				$errores['displayname']="Error en la longitud del displayname."  ;
    				
    				//telefono: numero de 9 digitos y que comienzen por 6,7,8 o 9
    				if (empty($this->phone)|| strlen($this->phone)<9 || strlen($this->phone)>9 
    						||!preg_match('/^[6-9]{1}[0-9]{8}$/i',$this->phone))
    					$errores['phone']="Error en el numero de telefono";
    					
    			//Otras comprobaciones que queramos filtrar
    			return $errores;
    }
   
}
    
    
