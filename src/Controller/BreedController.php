<?php
/**
 * Breed controller.
 */

namespace App\Controller;

use App\Entity\Breed;
use App\Service\BreedServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * Constructor.
     */
    public function __construct(BreedServiceInterface $breedService)
    {
        $this->breedService = $breedService;
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
}
