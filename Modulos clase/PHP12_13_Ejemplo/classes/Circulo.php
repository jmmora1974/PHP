<?php
class Circulo {
    // PROPIEDADES
     public Punto $centro; //Punto central
     public int $radio;
    
    //CONTRUTOR
    public function __construct(
        Punto $p,  //punto para el centro
        int $radio=1
        ){
        $this->centro =$p;
        $this->radio = $radio;
        
    }
    
    //eclipse genera solo los getters y setters
    
    
    
    
    /**
     * @return Punto
     */
    public function getCentro()
    {
        return $this->centro;
    }

    /**
     * @return number
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * @param Punto $centro
     */
    public function setCentro($centro)
    {
        $this->centro = $centro;
    }

    /**
     * @param number $radio
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;
    }

    //METODOS
    //desplaza un circulo (mueve su centro)
    /**
     * @param int $dx
     * @param int $dy
     * @return Circulo
     */
    public function mover (
        int $dx=0, //cuanto mover en X
        int $dy=0 //cuanto mover en Y
        ):Circulo{
        $this->centro->mover($dx,$dy);
        return $this;
    }
    
    //lleva un circulo al origen de coordenadas
    public function aOrigen():Circulo{
        $this->centro->aOrigen();
        return $this;
    }
    
    //metodo para calcular el area
    public function area():float{
        return pi()*$this->radio**2;
    }
    
    //metodo para calculat el perimetro
    public function perimetro(){
        return 2*pi()*$this->radio;
    }
    
    //Metodo de objeto que calcula la distancia entre dos circulos
    public function distanciaHasta(Circulo $c):float{
        return $this->centro ->distanciaHasta($c->centro)-($this->radio+$c->radio);
    }
    
    //metodo que comprueba si dos circulos tocan o no
    public function hitTest(Circulo $c):bool{
        return $this->distanciaHasta($c)<=0;
    }
    
    
    //Metodo __toString
    public function __toString():string{
        return "CIRCULO: $this->centro radio: $this->radio";
    }
}