<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
class Manga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $volumes = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cover_image = null;

    /*     #[ORM\Column]
        private ?bool $collected = null; */

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\ManyToOne(inversedBy: 'Manga')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'Manga')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    #[ORM\ManyToOne(inversedBy: 'Manga')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'Manga')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    /**
     * @var Collection<int, MangaUser>
     */
    #[ORM\OneToMany(targetEntity: MangaUser::class, mappedBy: 'manga')]
    private Collection $MangaUser;

    public function __construct()
    {
        $this->MangaUser = new ArrayCollection();
    }

    /*     #[ORM\Column]
        private ?bool $readed = null; */

    /*     #[ORM\Column]
        private ?int $collected_volumes = null; */

    /*     #[ORM\Column]
        private ?int $volumes_read = null; */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getVolumes(): ?int
    {
        return $this->volumes;
    }

    public function setVolumes(int $volumes): static
    {
        $this->volumes = $volumes;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->cover_image;
    }

    public function setCoverImage(string $cover_image): static
    {
        $this->cover_image = $cover_image;

        return $this;
    }

    /*     public function isCollected(): ?bool
        {
            return $this->collected;
        }

        public function setCollected(bool $collected): static
        {
            $this->collected = $collected;

            return $this;
        } */

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): static
    {
        $this->editor = $editor;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    /*     public function isReaded(): ?bool
        {
            return $this->readed;
        }

        public function setReaded(bool $readed): static
        {
            $this->readed = $readed;

            return $this;
        }

        public function getCollectedVolumes(): ?int
        {
            return $this->collected_volumes;
        }

        public function setCollectedVolumes(int $collected_volumes): static
        {
            $this->collected_volumes = $collected_volumes;

            return $this;
        }

        public function getVolumesRead(): ?int
        {
            return $this->volumes_read;
        }

        public function setVolumesRead(int $volumes_read): static
        {
            $this->volumes_read = $volumes_read;

            return $this;
        } */

    /**
     * @return Collection<int, MangaUser>
     */
    public function getMangaUser(): Collection
    {
        return $this->MangaUser;
    }

    public function addMangaUser(MangaUser $mangaUser): static
    {
        if (!$this->MangaUser->contains($mangaUser)) {
            $this->MangaUser->add($mangaUser);
            $mangaUser->setManga($this);
        }

        return $this;
    }

    public function removeMangaUser(MangaUser $mangaUser): static
    {
        if ($this->MangaUser->removeElement($mangaUser)) {
            // set the owning side to null (unless already changed)
            if ($mangaUser->getManga() === $this) {
                $mangaUser->setManga(null);
            }
        }

        return $this;
    }
}
