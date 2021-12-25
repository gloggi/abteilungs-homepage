<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 * @ApiResource(
 * collectionOperations={"get", "post"},
 *     itemOperations={
 *          "get"={},
 *          "put"
 *     },
 * normalizationContext={"groups"={"section:read"}}
 * )
 */
#[ApiResource]
class Section
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read", "section:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $from_age;

    /**
     * @ORM\Column(type="integer")
     */
    private $to_age;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="section")
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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

    public function getFromAge(): ?int
    {
        return $this->from_age;
    }

    public function setFromAge(?int $from_age): self
    {
        $this->from_age = $from_age;

        return $this;
    }

    public function getToAge(): ?int
    {
        return $this->to_age;
    }

    public function setToAge(int $to_age): self
    {
        $this->to_age = $to_age;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setSection($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getSection() === $this) {
                $group->setSection(null);
            }
        }

        return $this;
    }
}
