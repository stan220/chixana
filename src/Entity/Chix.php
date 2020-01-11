<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChixRepository")
 */
class Chix
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChixApprove", mappedBy="chix", orphanRemoval=true, fetch="EAGER")
     */
    private $approves;

    public function __construct()
    {
        $this->approves = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    public function isVerified(): bool
    {
        return !$this->approves->isEmpty();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|ChixApprove[]
     */
    public function getApproves(): Collection
    {
        return $this->approves;
    }

    public function addApprove(ChixApprove $approve): self
    {
        if (!$this->approves->contains($approve)) {
            $this->approves[] = $approve;
            $approve->setChix($this);
        }

        return $this;
    }

    public function removeApprove(ChixApprove $approve): self
    {
        if ($this->approves->contains($approve)) {
            $this->approves->removeElement($approve);
            // set the owning side to null (unless already changed)
            if ($approve->getChix() === $this) {
                $approve->setChix(null);
            }
        }

        return $this;
    }
}
