<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country, that is also a player.
 */
class BaseCountry implements CountryInterface
{

  /**
   * The name of the country.
   *
   * @var string
   */
  protected $name;
  protected $Conquest;
  protected $conqueredCountries;
  protected $neighbors = [];
  protected $troops = 3;
  /**
   * Builder.
   *
   * @param string $name
   *   The name of the country.
   */
  public function __construct(string $name)
  {
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setNeighbors(array $neighbors): void
  {
    foreach ($neighbors as $value) {
      array_push($this->neighbors, $value);
    }
  }

  public function getNeighbors(): array
  {
    return $this->neighbors;
  }

  public function isConquered(): bool
  {
    return $this->troops == 0 ? true : false;
  }

  public function killTroops(int $killedTroops): void
  {
    $this->troops = $this->troops - $killedTroops;
  }

  public function getNumberOfTroops(): int
  {
    return $this->troops;
  }

  public function conquer(CountryInterface $conqueredCountry): void
  {
    $conqueredCountry->setConquest($this);
    foreach ($conqueredCountry->getNeighbors() as $value) {
      if (!(in_array($value, $this->neighbors)) && !($value->getName() == $this->name)) {
        array_push($this->neighbors, $value);
      }
    }
    unset($this->neighbors[array_search($conqueredCountry, $this->neighbors)]);
    if (in_array($this, $this->neighbors))
      unset($this->neighbors[array_search($this, $this->neighbors)]);
  }
  public function setConquest(CountryInterface $ConquestCountry): void
  {
    $this->Conquest = $ConquestCountry;
  }
  public function getConquest(): CountryInterface
  {
    return $this->Conquest;
  }
  public function addTroops(int $troopsAdd): void
  {
    $this->troops += $troopsAdd + $this->conqueredCountries;
  }
}
