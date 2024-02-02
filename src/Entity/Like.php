<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'likes_count')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tweet $tweet_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $like_date = null;

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

    public function getLikeDate(): ?\DateTimeInterface
    {
        return $this->like_date;
    }

    public function setLikeDate(\DateTimeInterface $like_date): static
    {
        $this->like_date = $like_date;

        return $this;
    }
}
