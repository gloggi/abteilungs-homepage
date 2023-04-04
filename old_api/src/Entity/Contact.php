<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"contact:read"}},
 * )
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"contact:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact:read"})
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact:read"})
     */
    private $eMail;

    /**
     * @ORM\Column(type="float")
     * @Groups({"contact:read"})
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity=MediaObject::class, inversedBy="contacts")
     * @Groups({"contact:read"})
     */
    private $image;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->eMail;
    }

    public function setEMail(string $eMail): self
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function getSort(): ?float
    {
        return $this->sort;
    }

    public function setSort(float $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }
}
