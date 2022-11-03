<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="app_genre")
     */
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('genre/index.html.twig', [
            'genres'          => $genreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/genre/create", name="app_genre_create")
     */
    public function create(Request $request): Response
    {
        $genre = new Genre(); 
        $form = $this->createForm(GenreType::class, $genre); 
        $form->handleRequest($request); 
    
        if($form ->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($genre); 
            $entityManager->flush(); 
            
            return $this->redirectToRoute('app_genre');
        } return $this->render('genre/create.html.twig', [
            'genre' => $genre, 
            'form' => $form->createView()  
        ]);
    }

    /**
     * @Route("/genre/{genre}/edit", name="app_genre_edit")
     */
    public function edit(Request $request, Genre $genre): Response
    {
        $form = $this->createForm(GenreType::class, $genre); 
        $form->handleRequest($request); 
    
        if($form ->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($genre); 
            $entityManager->flush(); 
            
            return $this->redirectToRoute('app_genre');
        } return $this->render('genre/edit.html.twig', [
            'genre' => $genre, 
            'form' => $form->createView()  
        ]);
    }
    
    /**
     * @Route("/genre/{genre}/delete", name="app_genre_delete")
     */
    public function delete(Request $request, Genre $genre): Response
    {
        if ($genre){
            
        $this->getDoctrine()->getManager()->remove($genre);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_genre');
        }
    }
}
    

