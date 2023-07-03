<?php
/**
 * Dog fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Dog;
use App\Entity\Breed;
use App\Entity\Gender;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class DogFixtures.
 */
class DogFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'dogs', function (int $i) {
            $dog = new Dog();
            $dog->setName($this->faker->word());
            $dog->setAge($this->faker->numberBetween(1, 19));
            $dog->setDescription($this->faker->paragraphs(2, true));
            /** @var Breed $breed */
            $breed = $this->getRandomReference('breeds');
            $dog->setBreed($breed);
            /** @var Gender $gender */
            $gender = $this->getRandomReference('genders');
            $dog->setGender($gender);

            return $dog;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: BreedFixtures::class, 1: GenderFixtures::class}
     */
    public function getDependencies(): array
    {
        return [BreedFixtures::class, GenderFixtures::class];
    }
}
