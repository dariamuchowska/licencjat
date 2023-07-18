<?php
/**
 * Information page controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InfoController.
 */
class InfoController extends AbstractController
{
    /**
     * Info action.
     *
     * @return Response HTTP Response
     *
     * @Route("/info", name="app_info", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('info.html.twig');
    }
}