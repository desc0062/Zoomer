<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[Vich\Uploadable]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nbOfPlaces = null;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private $imageAct;

    #[Vich\UploadableField(mapping: 'activity', fileNameProperty: 'imageAct')]
    private ?File $imageActFile = null;

    public function setImageActFile(File $imageActFile = null): void
    {
        $this->imageActFile = $imageActFile;

        if (null !== $imageActFile) {
            $this->update_at = new \DateTimeImmutable();
        }
    }

    public function getImageActFile(): ?File
    {
        return $this->imageActFile;
    }

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getNbOfPlaces(): ?int
    {
        return $this->nbOfPlaces;
    }

    public function setNbOfPlaces(int $nbOfPlaces): static
    {
        $this->nbOfPlaces = $nbOfPlaces;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setActivity($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getActivity() === $this) {
                $booking->setActivity(null);
            }
        }

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getImageAct()
    {
        return $this->imageAct;
    }

    public function setImageAct($imageAct): static
    {
        $this->imageAct = $imageAct;

        return $this;
    }
}
