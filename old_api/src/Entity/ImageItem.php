<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageItemRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"imageitem:read"}},
 * )
 */
class ImageItem extends PageItem
{

    /**
     * @ORM\ManyToMany(targetEntity=MediaObject::class, inversedBy="imageItems")
     * @Groups({"imageitem:read"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    /**
     * @return Collection|MediaObject[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(MediaObject $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(MediaObject $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }
}
