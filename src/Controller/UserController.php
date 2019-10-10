<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     * @Route("/admin/user/edit/{id}", name="user_edit")
     */
    public function users(UserRepository $userRepos,
                        ObjectManager $manager,
                        Request $request,
                        UserPasswordEncoderInterface $encoder,
                        User $user=null)
    {
        if(!$user) {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            if(!$user->getRoles()) {
                $user->setRoles(['ROLE_USER']);
            }

            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('user/index.html.twig', [
            'users' => $userRepos->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="user_delete")
     */
    public function delete(User $user, ObjectManager $manager) {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_users');
    }
}
