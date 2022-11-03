<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Form\ActeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActeurRepository;
use Doctrine\ORM\EntityManagerInterface;

class ActeursController extends AbstractController
{
    /**
    * @Route("/acteurs", name="app_acteurs")
    */
    public function index(): Response
    {
        $acteurs = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->findAll();
        return $this->render('acteurs/index.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs'          => $acteurs
        ]);
    }

     /**
     * @Route("/acteur/{id}", name="acteur")
     */
    public function indiv(ActeurRepository $res ,$id): Response
    {
        $acteur=$res->find($id);
        return $this->render('acteurs/acteur.html.twig', [
            'controller_name' => 'ActeursController',
            'acteur'          => $acteur
        ]);
    }

    /**
    * @Route("/acteurs/create", name="app_acteurs_create")
    */
    public function create(Request $request,EntityManagerInterface $manager): Response
    {
      $acteur=new Acteur();
      $form=$this->createForm(ActeurType::class,$acteur);
      $form->handleRequest($request);

        if($form->isSubmitted()){
            $file=$acteur->getPhoto();
            $file_name=$file->getClientOriginalName();

            try {
                $file->move(
                    $this->getParameter('photos_directory'),
                    $file_name
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $acteur->setPhoto($file_name);
            $manager->persist($acteur);
            $manager->flush();
            return $this->redirectToRoute("app_acteurs");
        }
        return $this->render("acteurs/create.html.twig",[
            'form'          => $form->createView()
        ]);
    }

    /**
    * @Route("/acteurs/{acteur}/edit", name="app_acteur_edit")
    */
    public function edit(Request $request,EntityManagerInterface $manager,Acteur $acteur): Response
    {
    
      $form=$this->createForm(ActeurType::class,$acteur);
      $form->handleRequest($request);

        if($form->isSubmitted()){
            $file=$acteur->getPhoto();  
            $file_name=$file->getClientOriginalName();

            try {
                $file->move(
                    $this->getParameter('photos_directory'),
                    $file_name
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $acteur->setPhoto($file_name);
            $manager->persist($acteur);
            $manager->flush();
            return $this->redirectToRoute("app_acteurs");
        }
        return $this->render("acteurs/edit.html.twig",[
           'form'          => $form->createView()
        ]);
    }
    
    /**
    * @Route("/acteurs/{id}/delete", name="app_acteur_delete")
    */
    public function delete(EntityManagerInterface $manager,Acteur $id): Response
    {
    $manager->remove($id);
    $manager->flush();
        return $this->redirectToRoute('app_acteurs');
    } 
}