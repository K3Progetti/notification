<?php

namespace Esc\Notification\Controller;

use Esc\Notification\Repository\NotificationRepository;
use Esc\RequestParams;
use Esc\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private $notificationRepository;
    private $result;

    public function __construct(NotificationRepository $notificationRepository, Result $result)
    {
        $this->notificationRepository = $notificationRepository;
        $this->result = $result;
    }

    /**
     * @Route("/api/notifications", name="read_notifications", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function readNotifications(Request $request): JsonResponse
    {
        $requestParams = RequestParams::fromRequest($request);

        try {
            $this->result->setData($this->notificationRepository->findByCriteria($requestParams));
            $this->result->setTotalRows(
                $this->notificationRepository->countByCriteria($requestParams->get('filters'))
            );
            return $this->json($this->result->toArray());
        } catch (\Exception $e) {
            $this->result->setMessage($e->getMessage());
            return $this->json($this->result->toArray(), 400);
        }
    }
}
