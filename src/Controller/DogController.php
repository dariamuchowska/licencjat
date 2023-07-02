<?php
/**
 * Dog controller.
 */

namespace App\Controller;

use App\Entity\Dog;
use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class DogController.
 */
#[Route('/dog')]
class DogController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request        HTTP Request
     * @param DogRepository      $dogRepository Dog repository
     * @param PaginatorInterface $paginator      Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'dog_index', methods: 'GET')]
    public function index(Request $request, DogRepository $dogRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $dogRepository->queryAll(),
            $request->query->getInt('page', 1),
            DogRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('dog/index.html.twig', ['pagination' => $pagination]);
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
