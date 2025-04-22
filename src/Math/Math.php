<?php
namespace Projetux\Math;


class Math {
    
    /**
     *  @return int|float
     */

    public function soma(int|float $numero, int|float $numero2){
        return $numero + $numero2;
    }

    /**
     *  @return int|float
     */

    public function menos(int|float $numero, int|float $numero2){
        return $numero - $numero2;

    }

    /**
     *  @return int|float
     */

    public function produto(int|float $numero, int|float $numero2){
        return $numero * $numero2;
    }

    /**
     *  @return int|float
     */

     public function divide(int|float $numero, int|float $numero2){
        if($numero2 == 0){
            echo "deu errado";
        }
        else{
            return $numero / $numero2; 
        }
     }

     /**
     *  @return int|float
     */

    public function quadrado(int|float $numero){
        return $numero**2;
    }

    public function raiz(int|float $numero){
        return sqrt($numero);
    }






}



?>