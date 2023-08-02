<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        //SELECT * FROM employe ORDER BY nom ASC
        $employes = $employeRepository->findBy([],['nom' => "ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }
}
