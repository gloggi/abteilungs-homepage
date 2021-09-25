<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormRepository::class)
 */
#[ApiResource]
class Form extends Item
{
    

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=FormField::class, mappedBy="form")
     */
    private $form_fields;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __construct()
    {
        $this->form_fields = new ArrayCollection();
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

    /**
     * @return Collection|FormField[]
     */
    public function getFormFields(): Collection
    {
        return $this->form_fields;
    }

    public function addFormField(FormField $formField): self
    {
        if (!$this->form_fields->contains($formField)) {
            $this->form_fields[] = $formField;
            $formField->setForm($this);
        }

        return $this;
    }

    public function removeFormField(FormField $formField): self
    {
        if ($this->form_fields->removeElement($formField)) {
            // set the owning side to null (unless already changed)
            if ($formField->getForm() === $this) {
                $formField->setForm(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
