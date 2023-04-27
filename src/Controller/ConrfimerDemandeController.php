<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class ConrfimerDemandeController extends AbstractController
{
    #[Route('/conrfimer/les/demande', name: 'app_conrfimer_les_demande')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $demandes = $doctrine->getRepository(Demande::class)->findBy(['user' => $this->getUser()]);

        $demandeNC = [];

        foreach ($demandes as $uneD){
            if($uneD->getDateConfirmation() == null){
                $demandeNC[] = $uneD;
            }
        }

        foreach ($demandeNC as $d){
            $d->setDateConfirmation(new \DateTime());
            $doctrine->getManager()->persist($d);
            $doctrine->getManager()->flush();
        }

        return $this->render('conrfimer_les_demande/index.html.twig', [
            'user' => $doctrine->getRepository(User::class)->find($this->getUser()),
        ]);
    }
}
