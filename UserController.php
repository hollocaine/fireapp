<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/user")
*/

class UserController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'fname' =>'Alan',
            'sname' => 'Flynn',
            'email' => 'alan@gmail.com',
            'org_id' => 1,
            'department' => 'Office',
            'password' => 'password',
            'rights' => 3,
            'date' => '20-01-2020'
        ],
        [
            'id' => 2,
            'fname' =>'Jon',
            'sname' => 'Jones',
            'email' => 'jon@gmail.com',
            'org_id' => 2,
            'department' => 'Warehouse',
            'password' => 'password2',
            'rights' => 2,
            'date' => '17-01-2020'
        ],
        [
            'id' => 3,
            'fname' =>'Sarah',
            'sname' => 'Luck',
            'email' => 'sarah@yahoo.com',
            'org_id' => 3,
            'department' => 'Accounts',
            'password' => 'password',
            'rights' => 1,
            'date' => '20-01-2020'
        ]
    ];
    /**
    * @Route("/{page}", name="user_list", defaults={"page": 5}, requirements={"page"="\d+"})
    */
    public function list($page = 1,Request $request) {
      $limit = $request->get('limit', 10);
      return $this->json(
          [
                'page' => $page,
                'limit' => $limit, 
                'data' => array_map(function($item){
                    return $this->generateUrl('user_by_id', ['id' => $item['id']]);
                },self::POSTS)
          ]
        );
    }
    /**
    * @Route("/{id}", name="user_by_id", requirements={"id"="\d+"})
    */
    public function create($id) {
            $this->json(
                self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
            );
    }
    /**
    * @Route("/{id}", name="user_by_id")
    */
    public function delete($id) {
        return $this->json(
                self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
            );
    }
    /**
     * @Route("/add", name="user_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->json($user);
    }
}