<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getMobiles"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'brand_id', targetEntity: mobile::class)]
    private Collection $mobiles;

    public function __construct()
    {
        $this->mobiles = new ArrayCollection();
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

    /**
     * @return Collection<int, mobile>
     */
    public function getMobiles(): Collection
    {
        return $this->mobiles;
    }

    public function addMobile(mobile $mobile): self
    {
        if (!$this->mobiles->contains($mobile)) {
            $this->mobiles->add($mobile);
            $mobile->setBrandId($this);
        }

        return $this;
    }

    public function removeMobile(mobile $mobile): self
    {
        if ($this->mobiles->removeElement($mobile)) {
            // set the owning side to null (unless already changed)
            if ($mobile->getBrandId() === $this) {
                $mobile->setBrandId(null);
            }
        }

        return $this;
    }
}
