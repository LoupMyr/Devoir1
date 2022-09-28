<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]

#[ApiResource(normalizationContext:['groups' => ['read']],
              itemOperations:['GET'=>["security"=>"is_granted('ROLE_ADMIN')"]],
              collectionOperations:['GET'=>["security"=>"is_granted('ROLE_ADMIN')"]])]

class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(["read"])]
    private ?string $nom = null;

    #[Groups(["read"])]
    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 5)]
    private ?string $codepostal = null;

    #[ORM\OneToOne(mappedBy: 'referent', cascade: ['persist', 'remove'])]
    #[Groups(["read"])]
    private ?Etablissement $etablissement = null;

    #[ORM\ManyToMany(targetEntity: Etablissement::class, mappedBy: 'etab')]
    #[Groups(["read"])]
    private Collection $etablissements;

    public function __construct()
    {
        $this->etab = new ArrayCollection();
        $this->etablissements = new ArrayCollection();
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

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

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): self
    {
        // unset the owning side of the relation if necessary
        if ($etablissement === null && $this->etablissement !== null) {
            $this->etablissement->setReferent(null);
        }

        // set the owning side of the relation if necessary
        if ($etablissement !== null && $etablissement->getReferent() !== $this) {
            $etablissement->setReferent($this);
        }

        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->addEtab($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            $etablissement->removeEtab($this);
        }

        return $this;
    }
}
