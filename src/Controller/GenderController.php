<?php
/**
 * Gender controller.
 */

namespace App\Controller;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Service\GenderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GenderController.
 */
#[Route('/gender')]
class GenderController extends AbstractController
{
    /**
     * Gender service.
     */
    private GenderServiceInterface $genderService;

    /**
     * Constructor.
     */
    public function __construct(GenderServiceInterface $genderService)
    {
        $this->genderService = $genderService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request

     * @return Response HTTP response
     */
    #[Route(
        name: 'gender_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->genderService->getPaginatedList(
            $request->query->getInt('page', 1)
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

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'gender_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $gender = new Gender();
        $form = $this->createForm(
            GenderType::class,
            $gender
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->genderService->save($gender);

            return $this->redirectToRoute('gender_index');
        }

        return $this->render(
            'gender/create.html.twig',
            ['form' => $form->createView()]
        );
    }
}
