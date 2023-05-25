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
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 10; ++$i) {
            $dog = new Dog();
            $dog->setName($this->faker->sentence());
            $dog->setAge($this->faker->numberBetween(1, 19));
            $dog->setDescription($this->faker->paragraph());
            $dog->setPicture($this->faker->imageUrl(360, 360, 'animals', true, 'dogs', true));
            $dog->setSex($this->faker->randomElement(['female', 'male']));
            $dog->setSize($this->faker->randomElement(['small', 'medium', 'large']));
            $manager->persist($dog);
        }

        $manager->flush();
    }
}
