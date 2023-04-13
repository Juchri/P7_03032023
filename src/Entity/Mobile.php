<?php

namespace App\Entity;

use App\Repository\MobileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation\Groups;

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
    #[Assert\NotBlank(message: "Le modèle du téléphone est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le modèle doit faire au moins {{ limit }} caractère", maxMessage: "Le modèle ne peut pas faire plus de {{ limit }} caractères")]
    private ?string $model;

    #[ORM\ManyToOne(inversedBy: 'mobiles')]
    #[Groups(["getMobiles"])]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'mobiles')]
    #[ORM\JoinColumn(nullable: true)]
    private Client $client;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'mobiles')]
    private ?Collection $users = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

}
