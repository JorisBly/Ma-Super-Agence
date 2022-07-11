<?php

namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */

    private $repository;

    public function __construct(PropertyRepository $repository)
    {

        $this->repository = $repository;

    }


    public function index(ManagerRegistry $doctrine): Response
    {

        $property = $this->repository->findAllVisible();



        /*
        $entityManager = $doctrine->getManager();

        $property = new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice(3000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Une petite description de test')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Bordeaux')
            ->setAddress('15 Boulevard Gambetta')
            ->setPostalCode('3400');

            $entityManager->persist($property);
            $entityManager->flush();
        */

        return new Response($this->renderView('property/index.html.twig', ['current_menu' => 'properties']));
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*", "id"="\d+"})
     * @param Property $property
     * @param string $slug
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property, 'current_menu' => 'properties']);


    }

}