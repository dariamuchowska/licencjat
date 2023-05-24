<?php
/**
 * Dog controller.
 */

namespace App\Controller;

use App\Entity\Dog;
use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DogController.
 */
#[Route('/dog')]
class DogController extends AbstractController
{
    /**
     * Index action.
     *
     * @param DogRepository $dogRepository Dog repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'dog_index',
        methods: 'GET'
    )]
    public function index(DogRepository $dogRepository): Response
    {
        $dogs = $dogRepository->findAll();

        return $this->render(
            'dog/index.html.twig',
            ['dogs' => $dogs]
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
        methods: 'GET',
    )]
    public function show(Dog $dog): Response
    {
        return $this->render(
            'dog/show.html.twig',
            ['dog' => $dog]
        );
    }
}
