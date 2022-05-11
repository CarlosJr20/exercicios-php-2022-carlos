<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay;

use Galoa\ExerciciosPhp2022\War\GamePlay\Country\CountryInterface;

/**
 * A manager that will roll the dice and compute the winners of a battle.
 */
class Battlefield implements BattlefieldInterface
{
    public function rollDice(CountryInterface $country, bool $isAttacking): array
    {
        $isAttacking ? $troopsInCountry = $country->getNumberOfTroops() - 1 : $troopsInCountry = $country->getNumberOfTroops();
        $dice = [];
        for ($i = 0; $i < $troopsInCountry; $i++) {
            $dice[] = rand(1,6);
        }
        rsort($dice);
        return $dice;
    }

    public function computeBattle(CountryInterface $attackingCountry, array $attackingDice, CountryInterface $defendingCountry,array $defendingDice): void {
        $troopsAtack= $attackingDice > $defendingDice ? sizeof($defendingDice) : sizeof($attackingDice);
        $WinAttack = 0;
        $WinDefender = 0;

        while ($troopsAtack != 0) {
            if ($attackingDice[$troopsAtack - 1] > $defendingDice[$troopsAtack - 1]){
                ++$WinAttack;
            }else{
                ++$WinDefender;
                --$troopsAtack;
            }       
        }
        $attackingCountry->killTroops($WinDefender);
        $defendingCountry->killTroops($WinAttack);
    }
}
