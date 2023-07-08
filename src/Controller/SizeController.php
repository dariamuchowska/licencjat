<?php
/**
 * Size controller.
 */

namespace App\Controller;

use App\Entity\Size;
use App\Repository\SizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class SizeController.
 */
#[Route('/size')]
class SizeController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request        HTTP Request
     * @param SizeRepository     $sizeRepository Size repository
     * @param PaginatorInterface $paginator      Paginator
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'size_index',
        methods: 'GET'
    )]
    public function index(Request $request, SizeRepository $sizeRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $sizeRepository->queryAll(),
            $request->query->getInt('page', 1),
            SizeRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'size/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Size $size Size entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'size_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Size $size): Response
    {
        return $this->render(
            'size/show.html.twig',
            ['size' => $size]
        );
    }
}
