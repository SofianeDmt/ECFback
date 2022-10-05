<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository): Response
    {

        $panier = $session->get('panier', []);

        $panierTotal = [];

        foreach ($panier as $id => $quantite)
        {
            $panierTotal[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantite,
        ];
        }

        return $this->render('panier/index.html.twig', [
            'cart' => $panierTotal,
        ]);
    }

    public function resetPanier(SessionInterface $session)
    {
        $session->get('panier', []);
        $session->clear();
    }

}

