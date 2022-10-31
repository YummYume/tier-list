<?php

namespace App\Entity;

use App\Repository\TierListRankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TierListRankRepository::class)]
class TierListRank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'tierListRank', targetEntity: TierListItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $tierListItems;

    #[ORM\ManyToOne(inversedBy: 'tierListRanks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TierList $tierList = null;

    #[ORM\Column]
    private int $position = 0;

    public function __construct()
    {
        $this->tierListItems = new ArrayCollection();
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
     * @return Collection<int, TierListItem>
     */
    public function getTierListItems(): Collection
    {
        return $this->tierListItems;
    }

    public function addTierListItem(TierListItem $tierListItem): self
    {
        if (!$this->tierListItems->contains($tierListItem)) {
            $this->tierListItems->add($tierListItem);
            $tierListItem->setTierListRank($this);
        }

        return $this;
    }

    public function removeTierListItem(TierListItem $tierListItem): self
    {
        if ($this->tierListItems->removeElement($tierListItem)) {
            // set the owning side to null (unless already changed)
            if ($tierListItem->getTierListRank() === $this) {
                $tierListItem->setTierListRank(null);
            }
        }

        return $this;
    }

    public function getTierList(): ?TierList
    {
        return $this->tierList;
    }

    public function setTierList(?TierList $tierList): self
    {
        $this->tierList = $tierList;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
