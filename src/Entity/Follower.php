<?php

namespace App\Entity;

use App\Repository\FollowerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowerRepository::class)]
class Follower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'followers')]
    private ?User $followedId = null;

    #[ORM\ManyToOne(inversedBy: 'followers')]
    private ?User $followingId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $followingDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowedId(): ?User
    {
        return $this->followedId;
    }

    public function setFollowedId(?User $followedId): static
    {
        $this->followedId = $followedId;

        return $this;
    }

    public function getFollowingId(): ?User
    {
        return $this->followingId;
    }

    public function setFollowingId(?User $followingId): static
    {
        $this->followingId = $followingId;

        return $this;
    }

    public function getFollowingDate(): ?\DateTimeInterface
    {
        return $this->followingDate;
    }

    public function setFollowingDate(\DateTimeInterface $followingDate): static
    {
        $this->followingDate = $followingDate;

        return $this;
    }
}
