<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
#[ApiResource]
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
     * @ORM\OneToMany(targetEntity=PageItem::class, mappedBy="page", cascade={"persist"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $pageItems;

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
}
