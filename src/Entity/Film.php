<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resume;

    /**
     * @ORM\Column(type="date")
     */
    private $annee_sortie;

    /**
     * @ORM\Column(type="text")
     */
    private $affiche;

    /**
     * @ORM\ManyToMany(targetEntity=Acteur::class, inversedBy="films")
     */
    private $acteurs;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="films")
     */
    private $genre;

    public function __construct()
    {
        $this->acteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getAnneeSortie(): ?\DateTimeInterface
    {
        return $this->annee_sortie;
    }

    public function setAnneeSortie(\DateTimeInterface $annee_sortie): self
    {
        $this->annee_sortie = $annee_sortie;

        return $this;
    }

    public function getAffiche()
    {
        return $this->affiche;
    }

    public function setAffiche($affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * @return Collection<int, Acteur>
     */
    public function getActeurs(): Collection
    {
        return $this->acteurs;
    }

    public function addActeur(Acteur $acteur): self
    {
        if (!$this->acteurs->contains($acteur)) {
            $this->acteurs[] = $acteur;
        }

        return $this;
    }

    public function removeActeur(Acteur $acteur): self
    {
        $this->acteurs->removeElement($acteur);

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
