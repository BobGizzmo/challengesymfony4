<?php

namespace App\Controller;

use App\Entity\House;
use App\Repository\CityRepository;
use App\Repository\HouseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(UserRepository $userRepos,
                        CityRepository $cityRepos,
                        CacheInterface $cache)
    {
        $houses = $cache->get('houses', function(ItemInterface $item) {
            $item->expiresAfter(3600);
            $houseRepos = $this->getDoctrine()->getRepository(House::class);
            return $houseRepos->findAll();
        });
        
        return $this->render('admin/index.html.twig', [
            'houses' => $houses,
            'users' => $userRepos->findAll(),
            'citys' => $cityRepos->findAll()
        ]);
    }
}
