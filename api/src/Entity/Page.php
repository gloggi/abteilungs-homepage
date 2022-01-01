<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ORM\HasLifecycleCallbacks
 * 
 */
#[ApiResource(
    attributes: ["pagination_items_per_page"=>30]
                  
          
)]
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    /**
     * @ORM\OneToMany(targetEntity=PageItem::class, mappedBy="page", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $pageItems;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->pageItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Collection|PageItem[]
     */
    public function getPageItems(): Collection
    {
        return $this->pageItems;
    }

    public function addPageItem(PageItem $pageItem): self
    {
        if (!$this->pageItems->contains($pageItem)) {
            $this->pageItems[] = $pageItem;
            $pageItem->setPage($this);
        }

        return $this;
    }

    public function removePageItem(PageItem $pageItem): self
    {
        if ($this->pageItems->removeElement($pageItem)) {
            // set the owning side to null (unless already changed)
            if ($pageItem->getPage() === $this) {
                $pageItem->setPage(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTimeImmutable('now'));
        }
    }
}
