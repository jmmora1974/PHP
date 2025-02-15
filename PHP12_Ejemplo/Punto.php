<?php
class Punto {
    //Propiedades estsaticas
    public static int $creados =0;
    //Constructor
    public function __construct(
        int $x=0,
        int $y=0        
        ){
            $this->x=$x;
            $this->y=$y;
            
            self::$creados++;
            
    }
    //Metodo mover
    public function mover(int$dx=0, int $dy=0):Punto{
        $this->x=$dx;
        $this->y=$dy;
        return $this;
    }
    
    //Metodo a origen
    public function aOrigen():Punto{
        $this->x=0;
        $this->y=0; 
        return $this;
    }
    
    //Metodo estatico qeu devuelve la dist entr dos puntos
    public static function distanciaEntre ( 
        Punto $p1,
        Punto $p2
        ):float {
        return hypot($p1->x-$p2->x, $p1->y-$p2->y);
    }
    
    //metodo de objeto que devuelve la distancia de este a otro punto
    public function distanciaHasta(
        Punto $p3, //punto que llega por parametro (el otros es $this)
        ):float{
            return self::distanciaEntre($this,$p3);
    }
    
    //metodo toString
    public function __toString () {
        return "($this->x, $this->y)";
    }
    
}