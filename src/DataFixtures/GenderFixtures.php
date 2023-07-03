<?php
/**
 * Gender fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Gender;

/**
 * Class GenderFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class GenderFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(2, 'genders', function (int $i) {
            $gender = new Gender();
            $gender->setName($this->faker->randomElement(['samiec', 'samica']));
            return $gender;
        });

        $this->manager->flush();
    }
}
