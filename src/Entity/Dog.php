<?php
/**
 * Dog entity.
 */

namespace App\Entity;

use App\Repository\DogRepository;
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
     * @var string|null Name
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name;

    /**
     * Age.
     *
     * @var int|null Age
     */
    #[ORM\Column(type: 'integer')]
    private ?int $age;

    /**
     * Description.
     *
     * @var string|null Description
     */
    #[ORM\Column(type: 'string', length: 500)]
    private ?string $description;

    /**
     * Dog's photo filename.
     *
     * @var string|null photoFilename
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $photoFilename;

    /**
     * Breed.
     *
     * @var Breed|null
     */
    #[ORM\ManyToOne(targetEntity: Breed::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Breed $breed = null;

    /**
     * Gender.
     *
     * @var Gender|null
     */
    #[ORM\ManyToOne(targetEntity: Gender::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gender $gender = null;

    /**
     * Size.
     *
     * @var Size|null
     */
    #[ORM\ManyToOne(targetEntity: Size::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Size $size = null;

    /**
     * Author.
     *
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private ?User $author;

    /**
     * Getter for id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     *
     * @param string|null $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for age.
     *
     * @return int|null Age
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Setter for age.
     *
     * @param int|null $age Age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * Getter for description.
     *
     * @return string|null Description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     *
     * @param string|null $description Description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for photo Filename.
     *
     * @return string|null Photo filename
     */
    public function getPhotoFilename(): ?string
    {
        return $this->photoFilename;
    }

    /**
     * Setter for Photo filename.
     *
     * @param string|null $photoFilename Photo filename
     */
    public function setPhotoFilename(?string $photoFilename): void
    {
        $this->photoFilename = $photoFilename;
    }

    /**
     * Getter for breed.
     *
     * @return Breed|null Breed
     */
    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    /**
     * Setter for breed.
     *
     * @param Breed|null $breed Breed
     */
    public function setBreed(?Breed $breed): void
    {
        $this->breed = $breed;
    }

    /**
     * Getter for gender.
     *
     * @return Gender|null Gender
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * Setter for gender.
     *
     * @param Gender|null $gender Gender
     */
    public function setGender(?Gender $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * Getter for size.
     *
     * @return Size|null Size
     */
    public function getSize(): ?Size
    {
        return $this->size;
    }

    /**
     * Setter for size.
     *
     * @param Size|null $size Size
     */
    public function setSize(?Size $size): void
    {
        $this->size = $size;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
