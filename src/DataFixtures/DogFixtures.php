<?php
/**
 * Dog fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Dog;
use Doctrine\Persistence\ObjectManager;

/**
 * Class DogFixtures.
 */
class DogFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $dog = new Dog();
            $dog->setName($this->faker->sentence());
            $dog->setAge($this->faker->numberBetween(1, 19));
            $dog->setDescription($this->faker->paragraphs(2, true));
            $this->manager->persist($dog);
        }

        $this->manager->flush();
    }
}
