<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
#[ApiResource]
class Event
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="event")
     */
    private $participating_groups;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $start_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $end_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $to_bring;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $downloads = [];

    public function __construct()
    {
        $this->participating_groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getParticipatingGroups(): Collection
    {
        return $this->participating_groups;
    }

    public function addParticipatingGroup(Group $participatingGroup): self
    {
        if (!$this->participating_groups->contains($participatingGroup)) {
            $this->participating_groups[] = $participatingGroup;
            $participatingGroup->setEvent($this);
        }

        return $this;
    }

    public function removeParticipatingGroup(Group $participatingGroup): self
    {
        if ($this->participating_groups->removeElement($participatingGroup)) {
            // set the owning side to null (unless already changed)
            if ($participatingGroup->getEvent() === $this) {
                $participatingGroup->setEvent(null);
            }
        }

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getStartPlace(): ?string
    {
        return $this->start_place;
    }

    public function setStartPlace(?string $start_place): self
    {
        $this->start_place = $start_place;

        return $this;
    }

    public function getEndPlace(): ?string
    {
        return $this->end_place;
    }

    public function setEndPlace(?string $end_place): self
    {
        $this->end_place = $end_place;

        return $this;
    }

    public function getToBring(): ?string
    {
        return $this->to_bring;
    }

    public function setToBring(?string $to_bring): self
    {
        $this->to_bring = $to_bring;

        return $this;
    }

    public function getDownloads(): ?array
    {
        return $this->downloads;
    }

    public function setDownloads(?array $downloads): self
    {
        $this->downloads = $downloads;

        return $this;
    }
}
