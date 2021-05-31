<?php

declare(strict_types=1);

/*
 * This file is part of Talent4tech blog project made by OD&B.
 * Credits Aliptic
 */

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    public const STATE_DRAFT = 'DRAFT';
    public const STATE_PUBLISHED = 'PUBLISHED';
    public const STATE_ARCHIVED = 'ARCHIVED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=128, maxMessage="Le titre doit faire maximum {{ limit }} caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="update")
     */
    private $updateAt;

    /**
     * @var null|\DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=10)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(length=128, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     */
    private $user;

    public function __construct()
    {
        $this->state = static::STATE_DRAFT;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Article
     */
    public function setState(string $state): Article
    {
        if ($this->state !== static::STATE_PUBLISHED && $state === static::STATE_PUBLISHED) {
            $this->publishedAt = new \DateTimeImmutable();
        }

        $this->state = $state;
        return $this;
    }


    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
