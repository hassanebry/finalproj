<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $nbre_place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="reservations")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trajet", inversedBy="reservations")
     */
    private $trajet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="reservation")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

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

    public function getNbrePlace(): ?int
    {
        return $this->nbre_place;
    }

    public function setNbrePlace(int $nbre_place): self
    {
        $this->nbre_place = $nbre_place;

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

        /**
         * @return Collection|Commentaire[]
         */
        public function getCommentaires(): Collection
        {
            return $this->commentaires;
        }

        public function addCommentaire(Commentaire $commentaire): self
        {
            if (!$this->commentaires->contains($commentaire)) {
                $this->commentaires[] = $commentaire;
                $commentaire->setReservation($this);
            }

            return $this;
        }

        public function removeCommentaire(Commentaire $commentaire): self
        {
            if ($this->commentaires->contains($commentaire)) {
                $this->commentaires->removeElement($commentaire);
                // set the owning side to null (unless already changed)
                if ($commentaire->getReservation() === $this) {
                    $commentaire->setReservation(null);
                }
            }

            return $this;
        }
}
