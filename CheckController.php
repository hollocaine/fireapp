<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/check")
 */
class CheckController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'question_id' => 1,
            'risk_level' => 3,
            'title' =>'Fire Check June',
            'report' =>'We are in trouble',
            'date' =>'20-05-2019',
            'actioned_by' =>'20-02-2020',
            'completed' =>'28-02-2020'

        ],
        [
            'id' => 2,
            'question_id' => 3,
            'risk_level' => 2,
            'title' =>'Fire Check June',
            'report' =>'not too bad',
            'date' =>'20-12-2019',
            'actioned_by' =>'20-01-2020',
            'completed' =>'28-02-2020'
        ],
        [
            'id' => 3,
            'question_id' => 3,
            'risk_level' => 2,
            'title' =>'Fire Check May',
            'report' =>'Its fine',
            'date' =>'20-05-2019',
            'actioned_by' =>'19-01-2020',
            'completed' =>'28-02-2020'
        ]
    ];

    /**
     * @Route("/{page}", name="check_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1,Request $request) {
        $limit = $request->get('limit', 10);
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function($item){
                    return $this->generateUrl('check_by_id', ['id' => $item['id']]);
                },self::POSTS)
            ]
        );
    }
    /**
     * @Route("/{id}", name="check_create_by_id", requirements={"id"="\d+"})
     */
    public function create($id) {
        $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/{id}", name="check_by_id")
     */
    public function delete($id) {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
     /**
     * @Route("/add", name="check_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $check = $serializer->deserialize($request->getContent(), Check::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($check);
        $em->flush();

        return $this->json($check);
    }
}