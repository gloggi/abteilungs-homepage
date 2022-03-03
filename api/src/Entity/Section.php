<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 * @ORM\Table(name="`section`")
 * @ApiResource(
 * collectionOperations={"get", "post"},
 *     itemOperations={
 *          "get"={},
 *          "put", "patch", "delete"
 *     },
 * denormalizationContext={"groups"={"section:write"}},
 * normalizationContext={"groups"={"section:read"}},
 * 
 * )
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group:read", "section:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read", "section:read", "section:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"group:read", "section:read", "section:write"})
     */
    private $fromAge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"group:read", "section:read", "section:write"})
     */
    private $toAge;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="section")
     * @Groups({"group:read", "section:read"})
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
        return $this->fromAge;
    }

    public function setFromAge(?int $fromAge): self
    {
        $this->fromAge = $fromAge;

        return $this;
    }

    public function getToAge(): ?int
    {
        return $this->toAge;
    }

    public function setToAge(?int $toAge): self
    {
        $this->toAge = $toAge;

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
