<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/question")
 */
class QuestionController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'question' =>'Is there a fire?',
            'location_id' => 1
        ],
        [
            'id' => 2,
            'question' =>'Is there an extinguisher',
            'location_id' => 1
        ],
        [
            'id' => 3,
            'question' =>'Is there a fire alarm',
            'location_id' => 1
        ]
    ];

    /**
     * @Route("/{page}", name="question_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1,Request $request) {
        $limit = $request->get('limit', 10);
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function($item){
                    return $this->generateUrl('question_by_id', ['id' => $item['id']]);
                },self::POSTS)
            ]
        );
    }
    /**
     * @Route("/{id}", name="question_create_by_id", requirements={"id"="\d+"})
     */
    public function create($id) {
        $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/{id}", name="question_by_id")
     */
    public function delete($id) {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
      /**
     * @Route("/add", name="question_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $question = $serializer->deserialize($request->getContent(), Question::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($question);
        $em->flush();

        return $this->json($question);
    }
}