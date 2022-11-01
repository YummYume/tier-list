<?php

namespace App\Entity;

use App\Repository\TierListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TierListRepository::class)]
class TierList
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Assert\Length(max: 1000)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'tierList', targetEntity: TierListRank::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $tierListRanks;

    public function __construct()
    {
        $this->tierListRanks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, TierListRank>
     */
    public function getTierListRanks(): Collection
    {
        return $this->tierListRanks;
    }

    public function addTierListRank(TierListRank $tierListRank): self
    {
        if (!$this->tierListRanks->contains($tierListRank)) {
            $this->tierListRanks->add($tierListRank);
            $tierListRank->setTierList($this);
        }

        return $this;
    }

    public function removeTierListRank(TierListRank $tierListRank): self
    {
        if ($this->tierListRanks->removeElement($tierListRank)) {
            // set the owning side to null (unless already changed)
            if ($tierListRank->getTierList() === $this) {
                $tierListRank->setTierList(null);
            }
        }

        return $this;
    }
}
