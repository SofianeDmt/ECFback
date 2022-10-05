<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $produit = $doctrine->getRepository(Produit::class)->join();
        return $this->render('home/index.html.twig', [
            'produit' => $produit,
        ]);
    }

    public function menu(SessionInterface $session): Response
    {

        $cart = $session->get('panier');
        $count = count($cart);



        $listMenu = [
            ['title' => 'Ma Boutique', 'text' => 'Accueil', 'url' => $this->generateUrl('home')],
            ['title' => 'Panier', 'text' => 'Panier', 'url' => $this->generateUrl('panier')],
        ];

        return $this->render("parts/menu.html.twig", ['listmenu' => $listMenu, 'count' => $count]);
    }

}
