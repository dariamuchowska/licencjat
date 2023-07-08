<?php
/**
 * Breed controller.
 */

namespace App\Controller;

use App\Entity\Breed;
use App\Repository\BreedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BreedController.
 */
#[Route('/breed')]
class BreedController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request         HTTP Request
     * @param BreedRepository    $breedRepository Breed repository
     * @param PaginatorInterface $paginator       Paginator
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'breed_index',
        methods: 'GET'
    )]
    public function index(Request $request, BreedRepository $breedRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $breedRepository->queryAll(),
            $request->query->getInt('page', 1),
            BreedRepository::PAGINATOR_ITEMS_PER_PAGE
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
