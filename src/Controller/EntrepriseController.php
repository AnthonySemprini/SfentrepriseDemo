<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManager;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    //public function index(EntityManagerInterface $entityManager): Response
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
       
        //$entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        // SELECT * FROM entreprise WHERE Strasbourg ORDER BY raisonSocial
        $entreprises = $entrepriseRepository->findBy([],["raisonSocial" => "ASC"]);
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
            
    }

    
    #[Route('/entreprise/new', name: 'new_entreprise')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entreprise = new Entreprise();
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){// verif si sbmit et valid

                $entreprise = $form->getData();
                // equivalent de prepare en pdo
                $entityManager->persist($entreprise);
                //equivalent de execute;
                $entityManager->flush();

                return $this->redirectToRoute('app_entreprise');//renvoi a la vue 
            }
        return $this->render('entreprise/new.html.twig',[
            'formAddEntreprise' => $form,
        ]);
    }
    
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}
