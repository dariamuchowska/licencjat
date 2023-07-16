<?php
/**
 * Dog fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Dog;
use App\Entity\Breed;
use App\Entity\Gender;
use App\Entity\User;
use App\Service\FileUploader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class DogFixtures.
 */
class DogFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    private static array $dogPhotos = [
        'dog_1.jpeg',
        'dog_2.jpeg',
        'dog_3.jpeg',
        'dog_4.jpeg',
        'dog_5.png',
        'dog_6.jpeg',
        'dog_7.jpeg',
        'dog_8.jpeg',
        'dog_9.jpeg',
        'dog_10.jpeg',
    ];

    /**
     * File uploader.
     *
     * @var FileUploader File uploader
     */
    private FileUploader $fileUploader;

    /**
     * Constructor.
     */
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

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

        $this->createMany(10, 'dogs', function (int $i) {
            $dog = new Dog();
            $dog->setName($this->faker->name());
            $dog->setAge($this->faker->numberBetween(1, 19));
            $dog->setDescription($this->faker->paragraphs(2, true));
            /** @var Breed $breed */
            $breed = $this->getRandomReference('breeds');
            $dog->setBreed($breed);
            /** @var Gender $gender */
            $gender = $this->getRandomReference('genders');
            $dog->setGender($gender);
            /** @var Size $size */
            $size = $this->getRandomReference('sizes');
            $dog->setSize($size);

            $dogPhoto = $this->fakeUploadImage();
            /* @var string $dogPhoto */
            $dog->setPhotoFilename($dogPhoto);

            /** @var User $author */
            $author = $this->getRandomReference('users');
            $dog->setAuthor($author);

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
     * @psalm-return array{0: BreedFixtures::class, 1: GenderFixtures::class, 2: SizeFixtures::class, 3: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [BreedFixtures::class, GenderFixtures::class, SizeFixtures::class, UserFixtures::class];
    }

    /**
     * Fake upload.
     *
     * @return string Path
     */
    private function fakeUploadImage(): string
    {
        $randomImage = $this->faker->randomElement(self::$dogPhotos);
        $fs = new Filesystem();
        $targetPath = sys_get_temp_dir().'/'.$randomImage;
        $fs->copy(__DIR__.'/images/'.$randomImage, $targetPath, true);

        return $this->fileUploader
            ->upload(new File($targetPath));
    }
}
