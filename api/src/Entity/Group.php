<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
#[ApiResource]
class Group
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
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_name;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="successor_group")
     */
    private $sucessor_groups;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="sucessor_groups")
     */
    private $successor_group;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $highlight_images = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anual_plan;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="participating_groups")
     */
    private $event;

    public function __construct()
    {
        $this->successor_group = new ArrayCollection();
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

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

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

    public function getContactMail(): ?string
    {
        return $this->contact_mail;
    }

    public function setContactMail(?string $contact_mail): self
    {
        $this->contact_mail = $contact_mail;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    public function setContactName(?string $contact_name): self
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function getSucessorGroups(): ?self
    {
        return $this->sucessor_groups;
    }

    public function setSucessorGroups(?self $sucessor_groups): self
    {
        $this->sucessor_groups = $sucessor_groups;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSuccessorGroup(): Collection
    {
        return $this->successor_group;
    }

    public function addSuccessorGroup(self $successorGroup): self
    {
        if (!$this->successor_group->contains($successorGroup)) {
            $this->successor_group[] = $successorGroup;
            $successorGroup->setSucessorGroups($this);
        }

        return $this;
    }

    public function removeSuccessorGroup(self $successorGroup): self
    {
        if ($this->successor_group->removeElement($successorGroup)) {
            // set the owning side to null (unless already changed)
            if ($successorGroup->getSucessorGroups() === $this) {
                $successorGroup->setSucessorGroups(null);
            }
        }

        return $this;
    }

    public function getHighlightImages(): ?array
    {
        return $this->highlight_images;
    }

    public function setHighlightImages(?array $highlight_images): self
    {
        $this->highlight_images = $highlight_images;

        return $this;
    }

    public function getAnualPlan(): ?string
    {
        return $this->anual_plan;
    }

    public function setAnualPlan(?string $anual_plan): self
    {
        $this->anual_plan = $anual_plan;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
