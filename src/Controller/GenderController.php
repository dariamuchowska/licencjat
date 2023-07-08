<?php
/**
 * Gender controller.
 */

namespace App\Controller;

use App\Entity\Gender;
use App\Repository\GenderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class GenderController.
 */
#[Route('/gender')]
class GenderController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request          HTTP Request
     * @param GenderRepository   $genderRepository Gender repository
     * @param PaginatorInterface $paginator        Paginator
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'gender_index',
        methods: 'GET'
    )]
    public function index(Request $request, GenderRepository $genderRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $genderRepository->queryAll(),
            $request->query->getInt('page', 1),
            GenderRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'gender/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Gender $gender Gender entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'gender_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Gender $gender): Response
    {
        return $this->render(
            'gender/show.html.twig',
            ['gender' => $gender]
        );
    }
}
