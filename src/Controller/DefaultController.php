<?php

namespace App\Controller;
use App\Repository\PlatV2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;


class DefaultController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var PlatV2Repository
     */
    private $repository;

    public function __construct(Environment $twig, PlatV2Repository $repository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function index(SessionInterface $session, PlatV2Repository $repository):Response
    {
        $plats = $this->repository->findall();
        return $this->render('frontend/client/index.html.twig',[
            'plats' => $plats
        ]);
    }

}