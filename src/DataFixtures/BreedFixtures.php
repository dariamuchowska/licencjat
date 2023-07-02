<?php
/**
 * Breed fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Breed;

/**
 * Class BreedFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class BreedFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'breeds', function (int $i) {
            $breed = new Breed();
            $breed->setName($this->faker->unique()->words(3, true));

            return $breed;
        });

        $this->manager->flush();
    }
}
