<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Utilisateur")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="date")
     */
    private $date_inscription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="utilisateur")
     */
    private $trajet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="utilisateur")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="utilisateur")
     */
    private $commentaires;

    public function __construct()
    {
        $this->trajet = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        if (!in_array('ROLE_USER', $roles))
        {
            $roles[] = 'ROLE_USER';
        }
        foreach ($roles as $role)
        {
            if(substr($role, 0, 5) !== 'ROLE_') {
                echo ("Chaque rôle doit commencer par 'ROLE_'");
            }
        }
        
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajet(): Collection
    {
        return $this->trajet;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajet->contains($trajet)) {
            $this->trajet[] = $trajet;
            $trajet->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajet->contains($trajet)) {
            $this->trajet->removeElement($trajet);
            // set the owning side to null (unless already changed)
            if ($trajet->getUtilisateur() === $this) {
                $trajet->setUtilisateur(null);
            }
        }

        return $this;
    }
    /**
        * @ORM\PrePersist()
        */
        public function prePersist()
        {
            $this->date_inscription = new \DateTime();
        }
        public function getSalt() {}
        public function getUsername() {}
        public function eraseCredentials() {}

        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;

            return $this;
        }

        public function __toString()
    {
        return $this->nom;
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
                $reservation->setUtilisateur($this);
            }

            return $this;
        }

        public function removeReservation(Reservation $reservation): self
        {
            if ($this->reservations->contains($reservation)) {
                $this->reservations->removeElement($reservation);
                // set the owning side to null (unless already changed)
                if ($reservation->getUtilisateur() === $this) {
                    $reservation->setUtilisateur(null);
                }
            }

            return $this;
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
                $commentaire->setUtilisateur($this);
            }

            return $this;
        }

        public function removeCommentaire(Commentaire $commentaire): self
        {
            if ($this->commentaires->contains($commentaire)) {
                $this->commentaires->removeElement($commentaire);
                // set the owning side to null (unless already changed)
                if ($commentaire->getUtilisateur() === $this) {
                    $commentaire->setUtilisateur(null);
                }
            }

            return $this;
        }

}
