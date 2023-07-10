<?php
/**
 * Dog controller.
 */

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use App\Service\DogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * Translator.
     */
    private TranslatorInterface $translator;


    /**
     * Constructor.
     *
     * @param DogServiceInterface $dogService Dog service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(DogServiceInterface $dogService, TranslatorInterface $translator)
    {
        $this->dogService = $dogService;
        $this->translator = $translator;
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

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'dog_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $dog = new Dog();
        $form = $this->createForm(
            DogType::class,
            $dog
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dogService->save($dog);

            $this->addFlash(
                'success',
                $this->translator->trans('message.dog_created_successfully')
            );

            return $this->redirectToRoute('dog_index');
        }

        return $this->render(
            'dog/create.html.twig',
            ['form' => $form->createView()]
        );
    }
}
