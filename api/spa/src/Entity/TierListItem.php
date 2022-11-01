<?php

namespace App\Entity;

use App\Repository\TierListItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TierListItemRepository::class)]
class TierListItem
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

    #[ORM\ManyToOne(inversedBy: 'tierListItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TierListRank $tierListRank = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    #[Groups(['tier_list'])]
    private int $position = 0;

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

    public function getTierListRank(): ?TierListRank
    {
        return $this->tierListRank;
    }

    public function setTierListRank(?TierListRank $tierListRank): self
    {
        $this->tierListRank = $tierListRank;

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
