<?php

namespace App\Entity;

class TrajetSearch{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string|null
     */
    private $depart;
    
    /**
     * @var string|null
     */
    private $arrive;

    /**
     * @var date|null
     */
    public $datedep;

    /**
     * @var int|null
     */
    private $place;

    /**
     * @return string|null
     */
    public function getDepart(): ?string
    {
        return $this->depart;
    }

    /**
     * @param string|null
     * @return TrajetSearch 
     */
    public function setDepart(string $depart): TrajetSearch
    {
        $this->depart = $depart;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArrive(): ?string
    {
        return $this->arrive;
    }

    /**
     * @param string|null
     * @return TrajetSearch 
     */
    public function setArrive(string $arrive): TrajetSearch
    {
        $this->arrive = $arrive;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlace(): ?int
    {
        return $this->place;
    }

    /**
     * @param int|null
     * @return TrajetSearch 
     */
    public function setPlace(int $place): TrajetSearch
    {
        $this->place = $place;
        return $this;
    }
    


}