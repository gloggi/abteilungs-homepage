<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ApiFilter(SearchFilter::class, properties={"type": "partial"})
 */
#[ApiResource(
    iri: 'http://schema.org/MediaObject',
    normalizationContext: ['groups' => ['media_object:read']],
    itemOperations: ['get'],
    collectionOperations: [
        'get',
        'post' => [
            'controller' => CreateMediaObjectAction::class,
            'deserialize' => false,
            'validation_groups' => ['Default', 'media_object_create'],
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
)]
class MediaObject
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    private ?int $id = null;

    #[ApiProperty(iri: 'http://schema.org/contentUrl')]
    #[Groups(['media_object:read', 'imageitem:read', 'contact:read'])]
    public ?string $contentUrl = null;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Assert\NotNull(groups: ['media_object_create'])]
    public ?File $file = null;

    /**
     * @ORM\Column(nullable=true)
     */
    public ?string $filePath = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['media_object:read', 'contact:read'])]
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['media_object:read', 'contact:read'])]
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=ImageItem::class, mappedBy="images")
     */
    private $imageItems;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="image")
     */
    private $contacts;

    public function __construct()
    {
        $this->imageItems = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|ImageItem[]
     */
    public function getImageItems(): Collection
    {
        return $this->imageItems;
    }

    public function addImageItem(ImageItem $imageItem): self
    {
        if (!$this->imageItems->contains($imageItem)) {
            $this->imageItems[] = $imageItem;
            $imageItem->addImage($this);
        }

        return $this;
    }

    public function removeImageItem(ImageItem $imageItem): self
    {
        if ($this->imageItems->removeElement($imageItem)) {
            $imageItem->removeImage($this);
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setImage($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getImage() === $this) {
                $contact->setImage(null);
            }
        }

        return $this;
    }
}