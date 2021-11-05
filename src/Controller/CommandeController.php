<?php

namespace App\Controller;
use App\Repository\PlatV2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

class CommandeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var PlatV2Repository
     */
    private $repository;

    public function __construct(Environment $twig,PlatV2Repository $repository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function index(SessionInterface $session, PlatV2Repository $repository):Response
    {
        $plats = $this->repository->findall();

        $panier = $session->get('panier', []);
        $panierWithData=[];
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'plat' => $repository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach($panier as $id => $quantity){
            $total += $repository->find($id)->getPrix() * $quantity;
        }

        return $this->render('frontend/client/commande.html.twig',[
            'plats' => $plats,
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    public function panier(SessionInterface $session, PlatV2Repository $repository):Response
    {
        $panier = $session->get('panier', []);
        $panierWithData=[];
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'plat' => $repository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach($panier as $id => $quantity){
            $total += $repository->find($id)->getPrix() * $quantity;
        }

        return $this->render('frontend/client/panier.html.twig',[
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    public function add($id, SessionInterface $session):Response
    {
        $panier = $session->get('panier', []);
        if (isset($panier[$id])) $panier[$id]++;
        else $panier[$id] = 1;
        $session->set('panier', $panier);
        // dd($session->get('panier'));
        return $this->redirectToRoute('commande');
    }

    public function remove($id,SessionInterface $session):Response
    {
        $panier = $session->get('panier',[]);
        if (isset($panier[$id])) unset($panier[$id]);
        $session->set('panier',$panier);
        return $this->redirectToRoute('commande');
    }
    public function clearPanier(SessionInterface $session, PlatV2Repository $repository):Response
    {
        $session->set('panier', []);
        return $this->redirectToRoute('commande');
    }
}