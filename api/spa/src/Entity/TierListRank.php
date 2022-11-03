<?php

namespace App\Entity;

use App\Repository\TierListRankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TierListRankRepository::class)]
class TierListRank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tier_list'])]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(length: 100)]
    #[Groups(['tier_list'])]
    private ?string $name = null;

    #[Assert\Length(max: 1000)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['tier_list'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'tierListRank', targetEntity: TierListItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups(['tier_list'])]
    private Collection $tierListItems;

    #[ORM\ManyToOne(inversedBy: 'tierListRanks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TierList $tierList = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    #[Groups(['tier_list'])]
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
