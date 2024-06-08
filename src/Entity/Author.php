<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    /**
     * @var Collection<int, Manga>
     */
    #[ORM\OneToMany(targetEntity: Manga::class, mappedBy: 'author')]
    private Collection $Manga;

    public function __construct()
    {
        $this->Manga = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    /**
     * @return Collection<int, Manga>
     */
    public function getManga(): Collection
    {
        return $this->Manga;
    }

    public function addManga(Manga $manga): static
    {
        if (!$this->Manga->contains($manga)) {
            $this->Manga->add($manga);
            $manga->setAuthor($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): static
    {
        if ($this->Manga->removeElement($manga)) {
            // set the owning side to null (unless already changed)
            if ($manga->getAuthor() === $this) {
                $manga->setAuthor(null);
            }
        }

        return $this;
    }
}
