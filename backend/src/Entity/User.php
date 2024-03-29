<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Tweet::class)]
    private Collection $tweets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Retweet::class)]
    private Collection $retweets;

    #[ORM\OneToMany(mappedBy: 'follower', targetEntity: Follower::class)]
    private Collection $followers;

    #[ORM\OneToMany(mappedBy: 'following', targetEntity: Follower::class)]
    private Collection $following;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LikeComment::class)]
    private Collection $likeComments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RetweetComment::class)]
    private Collection $retweetComments;

    public function __construct()
    {
        $this->tweets = new ArrayCollection();
        $this->retweets = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likeComments = new ArrayCollection();
        $this->retweetComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Tweet>
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }

    public function addTweet(Tweet $tweet): static
    {
        if (!$this->tweets->contains($tweet)) {
            $this->tweets->add($tweet);
            $tweet->setUser($this);
        }

        return $this;
    }

    public function removeTweet(Tweet $tweet): static
    {
        if ($this->tweets->removeElement($tweet)) {
            // set the owning side to null (unless already changed)
            if ($tweet->getUser() === $this) {
                $tweet->setUser(null);
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
            $retweet->setUser($this);
        }

        return $this;
    }

    public function removeRetweet(Retweet $retweet): static
    {
        if ($this->retweets->removeElement($retweet)) {
            // set the owning side to null (unless already changed)
            if ($retweet->getUser() === $this) {
                $retweet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Follower>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(Follower $follower): static
    {
        if (!$this->followers->contains($follower)) {
            $this->followers->add($follower);
            $follower->setFollower($this);
        }

        return $this;
    }

    public function removeFollower(Follower $follower): static
    {
        if ($this->followers->removeElement($follower)) {
            // set the owning side to null (unless already changed)
            if ($follower->getFollower() === $this) {
                $follower->setFollower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Follower[]
     */
    public function getFollowing(): Collection
    {
        return $this->following;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

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
            $likeComment->setUser($this);
        }

        return $this;
    }

    public function removeLikeComment(LikeComment $likeComment): static
    {
        if ($this->likeComments->removeElement($likeComment)) {
            // set the owning side to null (unless already changed)
            if ($likeComment->getUser() === $this) {
                $likeComment->setUser(null);
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
            $retweetComment->setUser($this);
        }

        return $this;
    }

    public function removeRetweetComment(RetweetComment $retweetComment): static
    {
        if ($this->retweetComments->removeElement($retweetComment)) {
            // set the owning side to null (unless already changed)
            if ($retweetComment->getUser() === $this) {
                $retweetComment->setUser(null);
            }
        }

        return $this;
    }
}
