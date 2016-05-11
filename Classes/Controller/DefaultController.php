<?php

namespace CedricZiel\Simplebase\Controller;

use CedricZiel\Simplebase\Framework\Controller\AbstractController;
use CedricZiel\SimplebaseNews\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package CedricZiel\Simplebase\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * Simple index action that interacts with the container
     */
    public function indexAction()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->get('entity_manager');
        $newsRepository = $em->getRepository(News::class);

        $news = $newsRepository->findAll();

        return new Response(var_dump($news, true));
    }
}
