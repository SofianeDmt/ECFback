<?php

namespace App\Controller;

use App\Entity\Produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit/{id}/{url}', name: 'produit')]
    #[ParamConverter('Produit', class: Produit::class)]
    public function index(Produit $produit,  SessionInterface $session, Request $request): Response
    {

        $quantite = $request->get('quantite');
        $id = $request->get('id');


        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id] += $quantite;
        } elseif($quantite > 0 ) {
            $panier[$id] = intval($quantite);
        }

        $session->set('panier', $panier);

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
        ]);
    }


}
