<?php

namespace App\Controller;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Environment;

class IngredientController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function add(Request $request):Response
    {
        $ingredient = new Ingredient();
        $form = $this->createFormBuilder($ingredient)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter un ingredient'])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ingredient = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();

        }

        return $this->render('frontend/gerant/add.html.twig',[
            'controller_name' => 'IngredientController',
            'form' =>$form->createView(),
        ]);

    }
}
