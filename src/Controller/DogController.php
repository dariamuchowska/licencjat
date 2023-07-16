<?php
/**
 * Dog controller.
 */

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use App\Entity\User;
use App\Service\DogServiceInterface;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DogController.
 */
#[Route('/dog')]
class DogController extends AbstractController
{
    /**
     * Dog service.
     */
    private DogServiceInterface $dogService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param DogServiceInterface $dogService Dog service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(DogServiceInterface $dogService, TranslatorInterface $translator)
    {
        $this->dogService = $dogService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'dog_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $filters = $this->getFilters($request);
        $page = $request->query->getInt('page', 1);
        $pagination = $this->dogService->getPaginatedList($page, $filters, $user);


        return $this->render(
            'dog/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Dog $dog Dog entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'dog_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Dog $dog): Response
    {
        return $this->render(
            'dog/show.html.twig',
            ['dog' => $dog]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'dog_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request, FileUploader $fileUploader): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $dog = new Dog();
        $dog->setAuthor($user);

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $photoFilename = $fileUploader->upload($photoFile);
                $dog->setPhotoFilename($photoFilename);
            }

            $this->dogService->save($dog);

            $this->addFlash(
                'success',
                $this->translator->trans('message.dog_created_successfully')
            );

            return $this->redirectToRoute('dog_index');
        }

        return $this->render(
            'dog/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Dog      $dog      Dog entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit',
        name: 'dog_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    #[IsGranted(
        'EDIT',
        subject: 'dog'
    )]
    public function edit(Request $request, Dog $dog, FIleUploader $fileUploader): Response
    {
        $form = $this->createForm(
            DogType::class,
            $dog,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('dog_edit', ['id' => $dog->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFilename = $form->get('photo')->getData();
            if ($photoFilename) {
                $photoFilename = $fileUploader->upload($photoFilename);
                $dog->setPhotoFilename($photoFilename);
            }
            $this->dogService->save($dog);

            $this->addFlash(
                'success',
                $this->translator->trans('message.dog_edited_successfully')
            );

            return $this->redirectToRoute('dog_index');
        }

        return $this->render(
            'dog/edit.html.twig',
            [
                'form' => $form->createView(),
                'dog' => $dog,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Dog      $dog      Dog entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/delete',
        name: 'dog_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    #[IsGranted(
        'DELETE',
        subject: 'dog'
    )]
    public function delete(Request $request, Dog $dog): Response
    {
        $form = $this->createForm(DogType::class, $dog, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('dog_delete', ['id' => $dog->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dogService->delete($dog);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('dog_index');
        }

        return $this->render(
            'dog/delete.html.twig',
            [
                'form' => $form->createView(),
                'dog' => $dog,
            ]
        );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{breed_id: int, size_id: int, gender_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['breed_id'] = $request->query->getInt('filters_breed_id');
        $filters['size_id'] = $request->query->getInt('filters_size_id');
        $filters['gender_id'] = $request->query->getInt('filters_gender_id');

        return $filters;
    }
}
