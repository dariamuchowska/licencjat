<?php
/**
 * Breed entity.
 */

namespace App\Entity;

use App\Repository\BreedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Breed.
 */
#[ORM\Entity(repositoryClass: BreedRepository::class)]
#[ORM\Table(name: 'breeds')]
#[UniqueEntity(fields: ['name'])]
class Breed
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
    #[ORM\Column(length: 255)]
    private ?string $name;

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
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
