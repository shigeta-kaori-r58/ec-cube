<?php
namespace Plugin\HogePlugin\Service;

use Plugin\HogePlugin\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class ReviewService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createReview($requestData, $userId)
    {
        // 必須チェック
        if (empty($requestData['productId']) || empty($requestData['rating'])) {
            throw new Exception('INVALID_REQUEST');
        }
        if (strlen($requestData['productId']) > 50 || !is_int($requestData['rating']) || $requestData['rating'] < 1 || $requestData['rating'] > 5) {
            throw new Exception('INVALID_REQUEST');
        }
        if (!empty($requestData['comment']) && strlen($requestData['comment']) > 300) {
            throw new Exception('INVALID_REQUEST');
        }
        // ID生成（UUIDなど外部生成に置換可能）
        $reviewId = bin2hex(random_bytes(10));
        $review = new Review();
        $review->setReviewId($reviewId);
        $review->setProductId($requestData['productId']);
        $review->setUserId($userId);
        $review->setRating($requestData['rating']);
        $review->setComment(isset($requestData['comment']) ? $requestData['comment'] : null);
        $review->setCreatedAt(new \DateTime());

        $this->entityManager->persist($review);
        $this->entityManager->flush();

        return $review;
    }
}