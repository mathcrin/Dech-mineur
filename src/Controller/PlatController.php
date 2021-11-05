<?php

namespace App\Controller;
use App\Entity\PlatV2;
use App\Form\PlatV2Type;
use App\Repository\PlatV2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Environment;

class PlatController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var PlatV2Repository
     */
    private $repository;
    /**
     * @var Request
     */

    public function __construct(Environment $twig,PlatV2Repository $repository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function index(PlatV2Repository $repository):Response
    {
        $plats = $this->repository->findall();

        return $this->render('frontend/gerant/admin.html.twig',[
            'plats' => $plats
        ]);
    }

    public function add(Request $request):Response
    {
        $platV2 = new PlatV2();
        $form = $this->createFormBuilder($platV2)
            ->add('nom', TextType::class)
            ->add('ingredients',TextType::class)
            ->add('prix',NumberType::class) // il eciste aussi un money type
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $platV2 = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($platV2);
            $entityManager->flush();
        }

        // $repository= $this->getDoctrine()->getRepository(PlatV2::class);
        $platV2 = $this->repository->findAll();
        dump($platV2);
        return $this->render('frontend/gerant/add.html.twig',[
            'controller_name' => 'Plats',
            'form' =>$form->createView(),
        ]);
    }

    public function remove(Request $request, PlatV2 $platV2){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($platV2);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    public function edit(Request $request,PlatV2 $platV2):Response
    {
        $form = $this->createForm(PlatV2Type::class, $platV2);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $platV2 = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($platV2);
            $entityManager->flush();
        }

        // $repository= $this->getDoctrine()->getRepository(PlatV2::class);
        $platV2 = $this->repository->findAll();
        dump($platV2);
        return $this->render('frontend/gerant/add.html.twig',[
            'controller_name' => 'Plats',
            'form' =>$form->createView(),
        ]);
    }
}