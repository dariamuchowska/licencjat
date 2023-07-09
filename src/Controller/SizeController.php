<?php
/**
 * Size controller.
 */

namespace App\Controller;

use App\Entity\Size;
use App\Service\SizeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SizeController.
 */
#[Route('/size')]
class SizeController extends AbstractController
{
    /**
     * Size service.
     */
    private SizeServiceInterface $sizeService;

    /**
     * Constructor.
     */
    public function __construct(SizeServiceInterface $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'size_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->sizeService->getPaginatedList(
            $request->query->getInt('page', 1)
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
