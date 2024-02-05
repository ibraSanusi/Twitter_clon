<?php

namespace App\Entity;

use App\Repository\TweetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TweetRepository::class)]
class Tweet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publishDate = null;

    #[ORM\ManyToOne(inversedBy: 'tweets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'tweet', targetEntity: Like::class)]
    private Collection $likes_count;

    #[ORM\OneToMany(mappedBy: 'tweet', targetEntity: Retweet::class)]
    private Collection $retweets;

    public function __construct()
    {
        $this->likes_count = new ArrayCollection();
        $this->retweets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): static
    {
        $this->publishDate = $publishDate;

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

    /**
     * @return Collection<int, Like>
     */
    public function getLikesCount(): Collection
    {
        return $this->likes_count;
    }

    public function addLikesCount(Like $likesCount): static
    {
        if (!$this->likes_count->contains($likesCount)) {
            $this->likes_count->add($likesCount);
            $likesCount->setTweet($this);
        }

        return $this;
    }

    public function removeLikesCount(Like $likesCount): static
    {
        if ($this->likes_count->removeElement($likesCount)) {
            // set the owning side to null (unless already changed)
            if ($likesCount->getTweet() === $this) {
                $likesCount->setTweet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Retweet>
     */
    public function getRetweets(): Collection
    {
        return $this->retweets;
    }

    public function addRetweet(Retweet $retweet): static
    {
        if (!$this->retweets->contains($retweet)) {
            $this->retweets->add($retweet);
            $retweet->setTweet($this);
        }

        return $this;
    }

    public function removeRetweet(Retweet $retweet): static
    {
        if ($this->retweets->removeElement($retweet)) {
            // set the owning side to null (unless already changed)
            if ($retweet->getTweet() === $this) {
                $retweet->setTweet(null);
            }
        }

        return $this;
    }
}
