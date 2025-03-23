<?php

/** Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones de FastLight.
 *@author Jose Migue Mora  <jmmora1974@gmail.com>
 * @author1 Robert Sallent <robertsallent@gmail.com>
 * 
 *
 * añadidos campo y metodos para el aspecto 
 * Última revisión: 22/03/2025
 */
#[AllowDynamicProperties] 
class User extends Model implements Authenticable{

    use Authorizable; // usa el trait authorizable
    
    
    /** @var array $jsonFields lista de campos JSON que deben convertirse en array PHP. */
    protected static $jsonFields = ['roles'];
    
    
    /** @var array $fillable lista de campos permitidos para asignaciones masivas usando el método create() */
    protected static $fillable = ['displayname', 'email', 'phone', 'password', 'picture', 'aspecto'];

    
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
                   AND password='$password'";
        
        $usuario = (DB_CLASS)::select($consulta, self::class);
        
        if($usuario)
            $usuario->parseJsonFields();
        
        return $usuario;
    }  
    /**
     *  Obtiene la variable tema que tiene configurada el usaurio para el aspeto
     *
     * @return string variable tema de la bbd
     */
    public function getAspecto(){
    	//Auth::check(); // autorización(solo usuarios registrados)
    	$consulta = "SELECT aspecto
                     FROM users
                     WHERE id =".$this->id;
    	
    	if($aspecto = (DB_CLASS)::select($consulta, self::class))
  
    		
    	return $aspecto;
    }
    
    /**
     *  Configura la variable aspecto que tiene configurada el usuario para el aspeto
     *
     * @return string variable aspecto de la bbd
     */
    public function setAspecto(string $aspectonew='Dark'){
    	Auth::check(); // autorización(solo usuarios registrados)
    	
    	$consulta = "UPDATE users SET aspecto='";
    	
    	switch($aspectonew){
    		case "Base" : $consulta .= "Base"; break;
    		case "Neon"   : $consulta .= "Neon"; break;
    		case "Retro"  : $consulta .= "Retro"; break;
    		// En el caso de no tener el aspecto (No informa del error) se establece por defecto el Dark
    		default       : $consulta .= "Dark ";
    	}
    	 $consulta .= "' WHERE id =".$this->id.";";
    	
    	if($aspecto = (DB_CLASS)::update($consulta, self::class))
    		
    		
    		return $aspecto;
    }
    
}
    
    
