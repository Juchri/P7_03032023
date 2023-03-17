<?php

namespace App\Entity;

use App\Repository\MobileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MobileRepository::class)]
class Mobile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getMobiles"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getMobiles"])]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getMobiles"])]
    private ?string $brand = null;

    #[ORM\ManyToOne(inversedBy: 'mobiles')]
    #[Groups(["getMobiles"])]
    private ?Brand $brand_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrandId(): ?Brand
    {
        return $this->brand_id;
    }

    public function setBrandId(?Brand $brand_id): self
    {
        $this->brand_id = $brand_id;

        return $this;
    }
}
