<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Manga>
     */
    #[ORM\OneToMany(targetEntity: Manga::class, mappedBy: 'category')]
    private Collection $Manga;

    public function __construct()
    {
        $this->Manga = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $manga->setCategory($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): static
    {
        if ($this->Manga->removeElement($manga)) {
            // set the owning side to null (unless already changed)
            if ($manga->getCategory() === $this) {
                $manga->setCategory(null);
            }
        }

        return $this;
    }
}
