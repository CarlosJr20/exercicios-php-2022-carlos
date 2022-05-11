<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country that is managed by the Computer.
 */
class ComputerPlayerCountry extends BaseCountry {
  public function chooseToAttack(): ?CountryInterface {
   
    if($this -> getNumberOfTroops() > 1 && rand(0,3) !=0){
      $neighborAtack = $this -> neighbors[array_rand($this -> neighbors)];
      while($neighborAtack -> isConquered()){
        $neighborAtack = $neighborAtack -> getConquest();
      }
      if($neighborAtack != $this){
        return $neighborAtack;
      }
    }
      return null;
  }

}
