<?php
/**
 * Size entity.
 */

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Size.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: SizeRepository::class)]
#[ORM\Table(name: 'sizes')]
#[ORM\UniqueConstraint(name: 'uq_sizes_name', columns: ['name'])]
#[UniqueEntity(fields: ['name'])]
class Size
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
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    /**
     * Getter for Id.
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
     * Setter for void.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * To string.
     *
     * @return string|null
     */
    public function __toString() {
        return $this->name;
    }
}
