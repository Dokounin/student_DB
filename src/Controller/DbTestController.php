<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Project;
use App\Entity\Student;
use App\Entity\SchoolYear;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DbTestController extends AbstractController
{
    #[Route('/db/test', name: 'app_db_test')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //récupération du repository des catégories
        $repository = $doctrine->getRepository(SchoolYear::class);
        // récupération de la liste complète de toutes les categories
        $schoolYears = $repository->findAll();
        //inspection de la liste
        dump($schoolYears);

        
        //récupération du repository des student
        $repository = $doctrine->getRepository(Student::class);
        // récupération de la liste complète de toutes les student
        $students = $repository->findAll();
        //inspection de la liste
        dump($students);
        
        //récupération du repository des student
        $repository = $doctrine->getRepository(Project::class);
        // récupération de la liste complète de toutes les student
        $projects = $repository->findAll();
        //inspection de la liste
        dump($projects);
        
        //récupération du repository des tags
        $repository = $doctrine->getRepository(Tag::class);
        // récupération de la liste complète de toutes les tags
        $tags = $repository->findAll();
        //inspection de la liste
        dump($tags);



        exit();
    }
}
