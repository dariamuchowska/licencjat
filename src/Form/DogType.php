<?php
/**
 * Dog type.
 */

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Breed;
use App\Entity\Gender;
use App\Entity\Size;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Validator\Constraints\Image;


/**
 * Class DogType.
 */
class DogType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'photo',
            FileType::class,
            [
                'label' => 'label.photo_req',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ]),
                ],
            ]
        );
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label.name',
                'required' => true,
                'attr' => ['max_length' => 100],
            ]);
        $builder->add(
            'age',
            TextType::class,
            [
                'label' => 'label.age',
                'required' => true,
            ]);
        $builder->add(
            'breed',
            EntityType::class,
            [
                'class' => Breed::class,
                'choice_label' => function ($breed): string {
                    return $breed->getName();
                },
                'label' => 'label.breed',
                'placeholder' => 'label.none',
                'required' => true,
            ]);
        $builder->add(
            'gender',
            EntityType::class,
            [
                'class' => Gender::class,
                'choice_label' => function ($gender): string {
                    return $gender->getName();
                },
                'label' => 'label.gender',
                'placeholder' => 'label.none',
                'required' => true,
            ]);
        $builder->add(
            'size',
            EntityType::class,
            [
                'class' => Size::class,
                'choice_label' => function ($size): string {
                    return $size->getName();
                },
                'label' => 'label.size',
                'placeholder' => 'label.none',
                'required' => true,
            ]);
        $builder->add(
            'description',
            TextType::class,
            [
                'label' => 'label.description',
                'required' => true,
                'attr' => ['max_length' => 500],
            ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Dog::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'dog';
    }
}
