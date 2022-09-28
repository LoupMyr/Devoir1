<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]

#[ApiResource(normalizationContext:['groups' => ['read']],
              itemOperations:['GET'],
              collectionOperations:['GET'])]

class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToOne(inversedBy: 'etablissement', cascade: ['persist', 'remove'])]
    private ?Professeur $referent = null;

    #[ORM\ManyToMany(targetEntity: Professeur::class, inversedBy: 'etablissements')]
    private Collection $etab;

    public function __construct()
    {
        $this->etab = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReferent(): ?Professeur
    {
        return $this->referent;
    }

    public function setReferent(?Professeur $referent): self
    {
        $this->referent = $referent;

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getEtab(): Collection
    {
        return $this->etab;
    }

    public function addEtab(Professeur $etab): self
    {
        if (!$this->etab->contains($etab)) {
            $this->etab->add($etab);
        }

        return $this;
    }

    public function removeEtab(Professeur $etab): self
    {
        $this->etab->removeElement($etab);

        return $this;
    }

}
