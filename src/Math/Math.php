<?php
namespace Projetux\Math;


class Math {
    /**
     *  @return int|float
     */

    public function areatriangulo(int|float $numero, int|float $numero2){
        return ($numero * $numero2)/2;

    }

    /**
     *  @return int|float
     */

    public function areaquadrado(int|float $numero, int|float $numero2){
        return $numero * $numero2;
    }

}



?>