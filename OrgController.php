<?php

namespace App\Controller;
use App\Entity\Org;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/org")
*/
class OrgController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'name' =>'Zero Industries',
            'address' => 'Unit 13 Baldonnel Aerodrome',
            'contact' => 'George Me',
            'email' => 'info@zero.com',
            'date' => '20-01-2019',
            'phone' => '01-1234564'
        ],
        [
            'id' => 2,
            'name' =>'Handle Bars Distribution',
            'address' => 'Unit 13 City West Dublin 24',
            'contact' => 'May Weather',
            'email' => 'info@handle.com',
            'date' => '17-08-2019',
            'phone' => '01-4658499'
        ],
        [
            'id' => 3,
            'name' =>'Canned Industries',
            'address' => 'Unit 563B Glasnevin Ind Dublin',
            'contact' => 'Anthony Thompson',
            'email' => 'info@canned.com',
            'date' => '01-03-2019',
            'phone' => '01-1234564'
        ]
    ];
    /**
    * @Route("/{page}", name="org_list", defaults={"page": 5}, requirements={"page"="\d+"})
    */
    public function list($page = 1,Request $request) {
      $limit = $request->get('limit', 10);
      return $this->json(
          [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function($item){
                    return $this->generateUrl('org_by_id', ['id' => $item['id']]);
                },self::POSTS)
          ]
        );
    }
    /**
    * @Route("/{id}", name="org_by_id", requirements={"id"="\d+"})
    */
    public function create($id) {
            $this->json(
                self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
            );
    }
    /**
     * @Route("/add", name="org_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $org = $serializer->deserialize($request->getContent(), Org::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($org);
        $em->flush();
        return $this->json($org);
    }
}