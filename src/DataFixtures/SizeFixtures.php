<?php
/**
 * Size fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Size;

/**
 * Class SizeFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class SizeFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(3, 'sizes', function (int $i) {
            $size = new Size();
            $size->setName($this->faker->unique()->word());
            return $size;
        });

        $this->manager->flush();
    }
}
