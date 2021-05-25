<?php

declare(strict_types=1);

/*
 * This file is part of Talent4tech blog project made by OD&B.
 * Credits Aliptic
 */

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index(Request $request,
                          ArticleRepository $articleRepository,
                          PaginatorInterface $paginator
    ): Response {
        $articles = $paginator->paginate(
            $articleRepository->findAllPublishedForPagination(),
            $request->query->getInt('page', 1)/*page number*/ ,
            10 // limit per page
        );

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
