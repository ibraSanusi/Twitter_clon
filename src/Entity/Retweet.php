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
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'retweets')]
    private ?Tweet $tweet_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $retweet_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTweetId(): ?Tweet
    {
        return $this->tweet_id;
    }

    public function setTweetId(?Tweet $tweet_id): static
    {
        $this->tweet_id = $tweet_id;

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
