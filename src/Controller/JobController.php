<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Job;
use App\Entity\Image;
use App\Entity\Candidature;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class JobController extends AbstractController
{
    #[Route('/job', name: 'app_job')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $job = new Job();
        $job->setType("Developpeur")
            ->setCompany("jammel")
            ->setDescription("LARAVEL")
            ->setExpiresAt(new \DateTimeImmutable())
            ->setEmail("yassine.slim@polytechnicien.tn");

        $image = new Image();
        $image->setUrl('https://cdn.pixabay.com/photo/2015/10/30/10/03/gold-1013618_960_720.jpg')
            ->setAlt('job de reves');
        $job->setImage($image);

        $candidature1 = new Candidature();
        $candidature1->setCandidat("Mahrez")
            ->setContenu("formation J2EE")
            ->setDate(new \DateTime())
            ->setJob($job);

        $candidature2 = new Candidature();
        $candidature2->setCandidat("Yahrez")
            ->setContenu("formation Symfony")
            ->setDate(new \DateTime())
            ->setJob($job);

        $entityManager->persist($image);
        $entityManager->persist($job);
        $entityManager->persist($candidature1);
        $entityManager->persist($candidature2);
        $entityManager->flush();

        return $this->render('job/index.html.twig', [
            'id' => $job->getId(),
        ]);
    }

    #[Route('/job/{id}', name: 'job_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $job = $entityManager->getRepository(Job::class)->find($id);

        if (!$job) {
            throw $this->createNotFoundException('No job found for id ' . $id);
        }

        $listCandidatures = $entityManager->getRepository(Candidature::class)->findBy(['job' => $job]);

        return $this->render('job/show.html.twig', [
            'job' => $job,
            'listCandidatures' => $listCandidatures,
        ]);
    }

    #[Route(path: "/Ajouter", name: "add_candidate")]
    public function addCandidate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidature = new Candidature();

        $form = $this->createFormBuilder($candidature)
            ->add('candidat', TextType::class)
            ->add('contenu', TextType::class, [
                'label' => 'Contenu',
            ])
            ->add('date', DateType::class)
            ->add('job', EntityType::class, [
                  'class' => Job::class,
                'choice_label' => 'type',
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('job/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/add", name: "ajout_job")]
    public function addJob(Request $request, EntityManagerInterface $entityManager): Response
    {
        $job = new Job();
        $form = $this->createForm("App\Form\JobType", $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('app_job');
        }

        return $this->render('job/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route ("/",name:"home")]
    public function home(EntityManagerInterface $em){
        $repo = $em->getRepository(Candidature::class);
        $lesCandidats = $repo->findAll();
// lancer la recherche quand on clique sur le bouton
        return $this->render('job/home.html.twig',
            ['lesCandidats' => $lesCandidats]);
    }

    #[Route ("/homeJob",name:"home_job")]
    public function homeJob(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Job::class);
        $lesJob = $repo->findAll();
// lancer la recherche quand on clique sur le bouton
        return $this->render('job/liste_job.html.twig',
            ['lesJob' => $lesJob]);
    }





}
