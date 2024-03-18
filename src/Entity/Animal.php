<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[Vich\Uploadable]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Activity::class, orphanRemoval: true)]
    private Collection $activities;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\Column(length: 170)]
    private ?string $habitat = null;

    #[ORM\Column]
    private ?int $esperanceVie = null;

    #[ORM\Column(length: 100)]
    private ?string $espece = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private $imageAni;

    #[Vich\UploadableField(mapping: 'animal', fileNameProperty: 'imageAni')]
    private ?File $imageAniFile = null;

    public function setImageAniFile(File $imageAniFile = null): void
    {
        $this->imageAniFile = $imageAniFile;

        if (null !== $imageAniFile) {
            $this->update_at = new \DateTimeImmutable();
        }
    }

    public function getImageAniFile(): ?File
    {
        return $this->imageAniFile;
    }

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setAnimal($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getAnimal() === $this) {
                $activity->setAnimal(null);
            }
        }

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getHabitat(): ?string
    {
        return $this->habitat;
    }

    public function setHabitat(string $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getEsperanceVie(): ?int
    {
        return $this->esperanceVie;
    }

    public function setEsperanceVie(int $esperanceVie): static
    {
        $this->esperanceVie = $esperanceVie;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getImageAni()
    {
        return $this->imageAni;
    }

    public function setImageAni($imageAni): static
    {
        $this->imageAni = $imageAni;

        return $this;
    }
}
