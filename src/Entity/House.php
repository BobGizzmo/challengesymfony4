<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HouseRepository")
 */
class House
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir remplir ce champ")
     * @Assert\Length(min=10, minMessage="Un minimum de 10 caractère")
     */
    private $nomination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir remplir ce champ")
     * @Assert\Url
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir remplir ce champ")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="houses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Merci de bien vouloir remplir ce champ")
     * @Assert\Length(min=10, minMessage="Un minimum de 10 caractères sont autorisés")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomination(): ?string
    {
        return $this->nomination;
    }

    public function setNomination(string $nomination): self
    {
        $this->nomination = $nomination;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
