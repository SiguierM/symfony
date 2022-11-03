<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Genre;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{
    /**
     * @Route("/films", name="app_films")
     */
    public function index(): Response
    {
        $films = $this->getDoctrine()
        ->getRepository(Film::class)
        ->findAll();
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films' => $films
        ]);
    }

      /**
     * @Route("/film/{id}", name="film")
     */
    public function indiv(FilmRepository $res ,$id): Response
    {
        $film=$res->find($id);
        return $this->render('films/film.html.twig', [
            'controller_name' => 'FilmsController',
            'film'          => $film
        ]);
    }

        /**
     * @Route("/film/{genreid}/genre", name="liste")
     */
    public function liste(FilmRepository $res ,$genreid): Response
    {
        $films=$res->findByGenre($genreid);
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films'          => $films
        ]);
    }
    
    /**
    * @Route("/films/create", name="app_films_create")
    */
    public function create(Request $request,EntityManagerInterface $manager): Response
    {
      $film=new Film();
      $form=$this->createForm(FilmType::class,$film);
      $form->handleRequest($request);
      
        if($form->isSubmitted()){
            $file=$film->getAffiche();
            $file_name=$file->getClientOriginalName();

            try {
                $file->move(
                    $this->getParameter('affiches_directory'),
                    $file_name
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $film->setAffiche($file_name);
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute("app_films");
        }
        return $this->render("films/create.html.twig",[
            'form'          => $form->createView()
        ]);
    }

    /**
     * @Route("/films/{film}/edit", name="app_films_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Film $film): Response
    {
      $form=$this->createForm(FilmType::class,$film);
      $form->handleRequest($request);
      
        if($form->isSubmitted()){
            $file=$film->getAffiche();
            $file_name=$file->getClientOriginalName();

            try {
                $file->move(
                    $this->getParameter('affiches_directory'),
                    $file_name
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $film->setAffiche($file_name);
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute("app_films");
        }
        return $this->render("films/edit.html.twig",[
            'form'          => $form->createView()
        ]);
    }
    
    /**
     * @Route("/films/{id}/delete", name="app_films_delete")
     */
    public function delete(EntityManagerInterface $manager,Film $id): Response
    {
    $manager->remove($id);
    $manager->flush();
        return $this->redirectToRoute('app_films');
    }
}
