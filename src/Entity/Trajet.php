<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Trajet")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville_depart;

    /**
     * @ORM\Column(type="date")
     */
    private $date_depart;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_depart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville_arrive;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrive;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_arrive;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_place;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_place_dispo;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="trajet")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="trajet")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="trajet")
     */
    private $avis;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDepart(): ?string
    {
        return $this->ville_depart;
    }

    public function setVilleDepart(string $ville_depart): self
    {
        $this->ville_depart = $ville_depart;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heure_depart;
    }

    public function setHeureDepart(\DateTimeInterface $heure_depart): self
    {
        $this->heure_depart = $heure_depart;

        return $this;
    }

    public function getVilleArrive(): ?string
    {
        return $this->ville_arrive;
    }

    public function setVilleArrive(string $ville_arrive): self
    {
        $this->ville_arrive = $ville_arrive;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->date_arrive;
    }

    public function setDateArrive(\DateTimeInterface $date_arrive): self
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }

    public function getHeureArrive(): ?\DateTimeInterface
    {
        return $this->heure_arrive;
    }

    public function setHeureArrive(\DateTimeInterface $heure_arrive): self
    {
        $this->heure_arrive = $heure_arrive;

        return $this;
    }

    public function getNbrePlace(): ?int
    {
        return $this->nbre_place;
    }

    public function setNbrePlace(int $nbre_place): self
    {
        $this->nbre_place = $nbre_place;

        return $this;
    }

    public function getNbrePlaceDispo(): ?int
    {
        return $this->nbre_place_dispo;
    }

    public function setNbrePlaceDispo(int $nbre_place_dispo): self
    {
        $this->nbre_place_dispo = $nbre_place_dispo;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

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

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setTrajet($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getTrajet() === $this) {
                $reservation->setTrajet(null);
            }
        }

        return $this;
    }

    /**
        * @ORM\PrePersist()
        */
        public function prePersist()
        {
            $this->date_ajout = new \DateTime();
        }

        /**
         * @return Collection|Avis[]
         */
        public function getAvis(): Collection
        {
            return $this->avis;
        }

        public function addAvi(Avis $avi): self
        {
            if (!$this->avis->contains($avi)) {
                $this->avis[] = $avi;
                $avi->setTrajet($this);
            }

            return $this;
        }

        public function removeAvi(Avis $avi): self
        {
            if ($this->avis->contains($avi)) {
                $this->avis->removeElement($avi);
                // set the owning side to null (unless already changed)
                if ($avi->getTrajet() === $this) {
                    $avi->setTrajet(null);
                }
            }

            return $this;
        }

}
