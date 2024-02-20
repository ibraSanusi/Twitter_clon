<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Tweet $tweet = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(nullable: true)]
    private ?int $parentComment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: LikeComment::class)]
    private Collection $likeComments;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: RetweetComment::class)]
    private Collection $retweetComments;

    public function __construct()
    {
        $this->likeComments = new ArrayCollection();
        $this->retweetComments = new ArrayCollection();
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

    public function getTweet(): ?Tweet
    {
        return $this->tweet;
    }

    public function setTweet(?Tweet $tweet): static
    {
        $this->tweet = $tweet;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getParentComment(): ?int
    {
        return $this->parentComment;
    }

    public function setParentComment(?int $parentComment): static
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, LikeComment>
     */
    public function getLikeComments(): Collection
    {
        return $this->likeComments;
    }

    public function addLikeComment(LikeComment $likeComment): static
    {
        if (!$this->likeComments->contains($likeComment)) {
            $this->likeComments->add($likeComment);
            $likeComment->setComment($this);
        }

        return $this;
    }

    public function removeLikeComment(LikeComment $likeComment): static
    {
        if ($this->likeComments->removeElement($likeComment)) {
            // set the owning side to null (unless already changed)
            if ($likeComment->getComment() === $this) {
                $likeComment->setComment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RetweetComment>
     */
    public function getRetweetComments(): Collection
    {
        return $this->retweetComments;
    }

    public function addRetweetComment(RetweetComment $retweetComment): static
    {
        if (!$this->retweetComments->contains($retweetComment)) {
            $this->retweetComments->add($retweetComment);
            $retweetComment->setComment($this);
        }

        return $this;
    }

    public function removeRetweetComment(RetweetComment $retweetComment): static
    {
        if ($this->retweetComments->removeElement($retweetComment)) {
            // set the owning side to null (unless already changed)
            if ($retweetComment->getComment() === $this) {
                $retweetComment->setComment(null);
            }
        }

        return $this;
    }
}
