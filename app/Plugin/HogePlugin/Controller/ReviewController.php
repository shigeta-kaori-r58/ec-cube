<?php
namespace Plugin\HogePlugin\Controller;

use Plugin\HogePlugin\Service\ReviewService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ReviewController
{
    private $reviewService;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->reviewService = new ReviewService($entityManager);
    }

    /**
     * @Route("/api/v1/reviews", name="api_review_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        try {
            // JWT認証からuserId取得例（フレームワーク依存）：本実装ではダミー
            $userId = $request->headers->get('X-User-Id', 'u0001');
            $content = json_decode($request->getContent(), true);
            $review = $this->reviewService->createReview($content, $userId);

            $data = [
                'status' => 'success',
                'data' => [
                    'reviewId'  => $review->getReviewId(),
                    'productId' => $review->getProductId(),
                    'rating'    => $review->getRating(),
                    'comment'   => $review->getComment(),
                    'createdAt' => $review->getCreatedAt()->format('Y-m-d\TH:i:s\Z'),
                    'userId'    => $review->getUserId(),
                ]
            ];
            return new JsonResponse($data, 201);
        } catch (Exception $e) {
            // エラー仕様準拠
            $codeTable = [
                'INVALID_REQUEST' => [400, 'INVALID_REQUEST', 'パラメータ不正'],
            ];
            $error = $codeTable[$e->getMessage()] ?? [500, 'INTERNAL_ERROR', 'サーバー内部エラー'];
            return new JsonResponse([
                'status' => 'error',
                'code' => $error[1],
                'message' => $error[2],
                'details' => [
                    'field' => '',
                    'reason' => $e->getMessage()
                ]
            ], $error[0]);
        }
    }
}