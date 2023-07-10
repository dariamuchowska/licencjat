<?php
/**
 * Breed controller.
 */

namespace App\Controller;

use App\Entity\Breed;
use App\Form\BreedType;
use App\Service\BreedServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class BreedController.
 */
#[Route('/breed')]
class BreedController extends AbstractController
{
    /**
     * Breed service.
     */
    private BreedServiceInterface $breedService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param BreedServiceInterface $breedService Breed service
     * @param TranslatorInterface   $translator   Translator
     */
    public function __construct(BreedServiceInterface $breedService, TranslatorInterface $translator)
    {
        $this->breedService = $breedService;
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
        name: 'breed_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->breedService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render(
            'breed/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Breed $breed Breed entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'breed_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Breed $breed): Response
    {
        return $this->render(
            'breed/show.html.twig',
            ['breed' => $breed]
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
        name: 'breed_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $breed = new Breed();
        $form = $this->createForm(
            BreedType::class,
            $breed
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->breedService->save($breed);

            $this->addFlash(
                'success',
                $this->translator->trans('message.breed_created_successfully')
            );

            return $this->redirectToRoute('breed_index');
        }

        return $this->render(
            'breed/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Breed    $breed    Breed entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit',
        name: 'breed_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Breed $breed): Response
    {
        $form = $this->createForm(
            BreedType::class,
            $breed,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('breed_edit', ['id' => $breed->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->breedService->save($breed);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('breed_index');
        }

        return $this->render(
            'breed/edit.html.twig',
            [
                'form' => $form->createView(),
                'breed' => $breed,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Breed    $breed    Breed entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/delete',
        name: 'breed_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Breed $breed): Response
    {
        $form = $this->createForm(BreedType::class, $breed, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('breed_delete', ['id' => $breed->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->breedService->delete($breed);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('breed_index');
        }

        return $this->render(
            'breed/delete.html.twig',
            [
                'form' => $form->createView(),
                'breed' => $breed,
            ]
        );
    }
}
