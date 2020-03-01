<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'name' =>'Main Office'
        ],
        [
            'id' => 2,
            'name' =>'Warehouse'
        ],
        [
            'id' => 3,
            'name' =>'Accounts'
        ]
    ];

    /**
     * @Route("/{page}", name="location_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1,Request $request) {
        $limit = $request->get('limit', 10);
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function($item){
                    return $this->generateUrl('location_by_id', ['id' => $item['id']]);
                },self::POSTS)
            ]
        );
    }
    /**
     * @Route("/{id}", name="location_create_by_id", requirements={"id"="\d+"})
     */
    public function create($id) {
        $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/{id}", name="location_by_id")
     */
    public function delete($id) {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/add", name="location_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        $location = $serializer->deserialize($request->getContent(), Location::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($location);
        $em->flush();

        return $this->json($location);
    }
}