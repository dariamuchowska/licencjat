<?php
/**
 * Dog controller.
 */

namespace App\Controller;

use App\Entity\Dog;
use App\Service\DogService;
use App\Service\DogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * Constructor.
     */
    public function __construct(DogServiceInterface $dogService)
    {
        $this->dogService = $dogService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'dog_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->dogService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

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
}
