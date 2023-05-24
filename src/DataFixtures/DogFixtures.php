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
            $task = new Dog();
            $task->setName($this->faker->sentence());
            $task->setAge($this->faker->numberBetween(1, 19));
            $task->setDescription($this->faker->paragraph());
            $task->setPicture($this->faker->imageUrl(360, 360, 'animals', true, 'dogs', true));
            $task->setSex($this->faker->randomElement(['female', 'male']));
            $task->setSize($this->faker->randomElement(['small', 'medium', 'large']));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
