<?php

namespace App\Entity;

use App\Repository\RetweetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetweetRepository::class)]
class Retweet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'retweets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'retweets')]
    private ?Tweet $tweet = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $retweet_date = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTweet(): ?Tweet
    {
        return $this->tweet;
    }

    public function setTweet(?Tweet $tweet): static
    {
        $this->tweet = $tweet;

        return $this;
    }

    public function getRetweetDate(): ?\DateTimeInterface
    {
        return $this->retweet_date;
    }

    public function setRetweetDate(\DateTimeInterface $retweet_date): static
    {
        $this->retweet_date = $retweet_date;

        return $this;
    }
}
