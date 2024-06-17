<?php

namespace App\Entity;

use App\Repository\MangaUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaUserRepository::class)]
class MangaUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $volume_number = null;

    #[ORM\Column]
    private ?bool $collected = null;

    #[ORM\Column]
    private ?bool $readed = null;

    #[ORM\ManyToOne(inversedBy: 'MangaUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'MangaUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manga $manga = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolumeNumber(): ?int
    {
        return $this->volume_number;
    }

    public function setVolumeNumber(int $volume_number): static
    {
        $this->volume_number = $volume_number;

        return $this;
    }

    public function isCollected(): ?bool
    {
        return $this->collected;
    }

    public function setCollected(bool $collected): static
    {
        $this->collected = $collected;

        return $this;
    }

    public function isReaded(): ?bool
    {
        return $this->readed;
    }

    public function setReaded(bool $readed): static
    {
        $this->readed = $readed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): static
    {
        $this->manga = $manga;

        return $this;
    }
}
