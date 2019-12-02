<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\HouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(HouseRepository $houseRepos)
    {        
        //findLast: Custom method in App\Repository\HouseRepository
        $houses = $houseRepos->findLast(12);

        return $this->render('site/index.html.twig', [
            'houses' => $houses
        ]);
    }

    /**
     * @Route("/team", name="team")
     */
    public function team()
    {
        return $this->render('site/team.html.twig', [
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre mail a bien été ignoré');
            //TO DO: Send a email ;)
        }
        return $this->render('site/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/mention-legales", name="mlegales")
     */
    public function mlegales()
    {
        return $this->render('site/mlegales.html.twig', [
        ]);
    }


    /**
     * @Route("/recette", name="recette")
     */
    public function recette()
    {
        return $this->render('site/recette.html.twig', [
        ]);
    }
}
