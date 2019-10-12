<?php

namespace App\Controller;

use App\Entity\House;
use App\Form\HouseType;
use App\Repository\CityRepository;
use App\Repository\HouseRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HouseController extends AbstractController
{
    /**
     * @Route("/house/{page}", name="house_home")
     */
    public function index(HouseRepository $houseRepository, $page)
    {
        //findByPage: Custom method in App\Repository\HouseRepository
        $houses = $houseRepository->findByPage($page-1, 12);
        $totalPage = round($houseRepository->count([])/12);
        return $this->render('house/index.html.twig', [
            'houses' => $houses,
            'nbPage' => $totalPage
        ]);
    }

    /**
     * @Route("/house/show/{id}", name="house_show")
     */
    public function show(House $house) {
        return $this->render('house/show.html.twig', [
            'house' => $house
        ]);
    }

    /**
     * @Route("/admin/house", name="admin_house")
     * @Route("/admin/house/edit/{id}", name="admin_edit_house")
     */
    public function admin(CacheInterface $cache,
                            Request $request,
                            ObjectManager $manager,
                            CityRepository $cityRepository,
                            HouseRepository $houseRepos,
                            House $house = null)
    {
        $form = $this->createForm(HouseType::class, $house);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $city = $cityRepository->find($request->request->get('house')['city']);
            if($request->request->get('id')) {
                $house = $houseRepos->find($request->request->get('id'));
            }
            else {
                $house = new House();
            }
            
            $house->setNomination($request->request->get('house')['nomination'])
                    ->setImage($request->request->get('house')['image'])
                    ->setPrice($request->request->get('house')['price'])
                    ->setDescription(nl2br($request->request->get('house')['description']))
                    ->setCity($city);

            $manager->persist($house);
            $manager->flush();

            $cache->delete('houses');//Deleted cache after insertion or update
        }

        $houses = $cache->get('houses', function(ItemInterface $item) {
            $item->expiresAfter(3600);
            $houseRepos = $this->getDoctrine()->getRepository(House::class);
            return $houseRepos->findAll();
        });

        return $this->render('admin/house.html.twig', [
            'houses' => $houses,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/house/delete/{id}", name="house_delete")
     */
    public function delete(House $house, ObjectManager $manager, CacheInterface $cache) {
        $manager->remove($house);
        $manager->flush();
        
        $cache->delete('houses');
        $this->addFlash('success', 'La '.$house->getNomination().' a bien été supprimé');

        return $this->redirectToRoute('admin_house');
    }


    /// AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX AJAX

    /**
     * @Route("/admin/house/ajax/{id}", name="admin_ajax_edit")
     */
    public function ajaxEdit(HouseRepository $houseRepos, $id) {
        $house = $houseRepos->find($id);
        $fields = ['Nomination', 'Image', 'Price', 'Description', 'City'];

        foreach($fields as $value) {
            $methode = 'get'.$value;
            if($value == 'City') {
                $houseArray[]= $house->$methode()->getId();
            }
            else {
                $houseArray[]= $house->$methode();
            }
        }
        $houseArray[] = $id;
        return $this->json(['code' => 200, 'house' => $houseArray], 200);
    }
}
