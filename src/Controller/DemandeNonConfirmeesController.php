<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeNonConfirmeesController extends AbstractController
{
    #[Route('/demande/non/confirmees', name: 'app_demande_non_confirmees')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $demandes = $doctrine->getRepository(Demande::class)->findBy(['user' => $this->getUser()]);

        $demandeNC = [];

        foreach ($demandes as $uneD){
            if($uneD->getDateConfirmation() == null){
                $demandeNC[] = $uneD;
            }
    }

        return $this->render('demande_non_confirmees/index.html.twig', [
            'values' => $demandeNC,
            'user' => $doctrine->getRepository(User::class)->find($this->getUser()),
        ]);
    }
}
