<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $auth)
    {
        //https://symfony.com/doc/current/security/form_login_setup.html
        //Récuperation de l'erreur si l'authentification a échoué
        
        //Pour message fr direction config/packages/translation.yaml puis remplacer en par fr
        //https://symfony.com/doc/current/translation.html
        $error = $auth->getLastAuthenticationError();
        //Recupère le username de la dernière tentative de connexion
        $lastUsername = $auth->getLastUsername();

        return $this->render('security/index.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }
}
