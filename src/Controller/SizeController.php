<?php
/**
 * Size controller.
 */

namespace App\Controller;

use App\Entity\Size;
use App\Form\SizeType;
use App\Service\SizeServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param SizeServiceInterface $sizeService Size service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(SizeServiceInterface $sizeService, TranslatorInterface $translator)
    {
        $this->sizeService = $sizeService;
        $this->translator = $translator;
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
    #[IsGranted(
        'ROLE_ADMIN'
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
    #[IsGranted(
        'ROLE_ADMIN'
    )]
    public function show(Size $size): Response
    {
        return $this->render(
            'size/show.html.twig',
            ['size' => $size]
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
        name: 'size_create',
        methods: 'GET|POST',
    )]
    #[IsGranted(
        'ROLE_ADMIN'
    )]
    public function create(Request $request): Response
    {
        $size = new Size();
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sizeService->save($size);

            $this->addFlash(
                'success',
                $this->translator->trans('message.size_created_successfully')
            );

            return $this->redirectToRoute('size_index');
        }

        return $this->render(
            'size/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Size     $size     Size entity
     *
     * @return Response HTTP response
     */
    #[IsGranted(
        'ROLE_ADMIN'
    )]
    #[Route(
        '/{id}/edit',
        name: 'size_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Size $size): Response
    {
        $form = $this->createForm(
            SizeType::class,
            $size,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('size_edit', ['id' => $size->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sizeService->save($size);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('size_index');
        }

        return $this->render(
            'size/edit.html.twig',
            [
                'form' => $form->createView(),
                'size' => $size,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Size    $size    Size entity
     *
     * @return Response HTTP response
     */
    #[IsGranted(
        'ROLE_ADMIN'
    )]
    #[Route(
        '/{id}/delete',
        name: 'size_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Size $size): Response
    {
        if(!$this->sizeService->canBeDeleted($size)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.size_contains_dogs')
            );

            return $this->redirectToRoute('size_index');
        }

        $form = $this->createForm(
            SizeType::class,
            $size,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('size_delete', ['id' => $size->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sizeService->delete($size);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('size_index');
        }

        return $this->render(
            'size/delete.html.twig',
            [
                'form' => $form->createView(),
                'size' => $size,
            ]
        );
    }
}
