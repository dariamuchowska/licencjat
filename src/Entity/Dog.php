<?php

/**
 * Dog entity.
 */

namespace App\Entity;

use App\Repository\DogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Dog.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: DogRepository::class)]
#[ORM\Table(name: 'dogs')]
class Dog
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
    * Name.
    *
    * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $name = null;

    /**
     * Age.
     *
     * @var int|null
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $age = null;

    /**
     * Description.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * Picture.
     *
     * @var null
     */
    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $picture = null;

    /**
     * Sex.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $sex = null;

    /**
     * Size.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'integer', length: 100, nullable: true)]
    private ?string $size = null;

    /**
     * Getter for ID.
     *
     * @return int|null ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name Name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for Age.
     *
     * @return int|null Age
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Setter for Age.
     *
     * @param int|null $age Age
     */
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    /**
     * Getter for Description.
     *
     * @return string|null Description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string $description Description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for Picture.
     *
     * @return null Picture.
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Setter for Picture.
     *
     * @param $picture Picture
     */
    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Getter for Sex.
     *
     * @return string|null Sex
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * Setter for Sex.
     *
     * @param string|null $sex Sex
     */
    public function setSex(?string $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * Getter for Size.
     *
     * @return string|null Size
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * Setter for Size.
     *
     * @param string|null $size Size
     */
    public function setSize(?string $size): void
    {
        $this->size = $size;
    }
}
