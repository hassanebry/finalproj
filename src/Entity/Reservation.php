<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Reservation")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_reserv;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_place_r;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="reservation")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trajet", inversedBy="reservations")
     */
    private $trajet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReserv(): ?\DateTimeInterface
    {
        return $this->date_reserv;
    }

    public function setDateReserv(\DateTimeInterface $date_reserv): self
    {
        $this->date_reserv = $date_reserv;

        return $this;
    }

    public function getNbrePlaceR(): ?int
    {
        return $this->nbre_place_r;
    }

    public function setNbrePlaceR(int $nbre_place_r): self
    {
        $this->nbre_place_r = $nbre_place_r;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
        * @ORM\PrePersist()
        */
        public function prePersist()
        {
            $this->date_reserv = new \DateTime();
        }
}
