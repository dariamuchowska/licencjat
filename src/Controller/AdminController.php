<?php
/**
 * Admin controller.
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController.
 *
 * @Route("/admin")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/',
        name: 'app_admin',
        methods: 'GET'
    )]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}