<?php
class Coche {
    //propiedades
    public string $marca, $modelo;
    public int $kms;
    
    //Constructor
    public function __construct(
        string $marca,
        string $modelo,
        int $kms=0
        ){
            $this->marca=$marca;
            $this->modelo=$modelo;
            $this->kms=$kms;
            
    }
    //Metodo avanzar
    public function avanzar(int $kms=0){
        $this->kms += $kms;
    }
    
    //metodo toString
    public function __toString () {
        return "COCHE: $this->marca $this->modelo $this->kms";
    }
    
    
}
