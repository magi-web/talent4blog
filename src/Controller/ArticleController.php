<?php

declare(strict_types=1);

/*
 * This file is part of Talent4tech blog project made by OD&B.
 * Credits Aliptic
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Workflow\Registry;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/article", name="article_")
 * @IsGranted("ROLE_USER")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        Request $request,
        ArticleRepository $articleRepository,
        PaginatorInterface $paginator,
        TranslatorInterface $translator
    ): Response {
        dump($translator->trans('symfony_is_great'));
        $articles = $paginator->paginate(
            $articleRepository->findAllForPagination(),
            $request->query->getInt('page', 1)/*page number*/ ,
            10 // limit per page
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            $article->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article, Registry $workflow): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newState = $request->request->get('state');
            $stateMachineArticle = $workflow->get($article, 'article');

            try {
                $stateMachineArticle->apply($article, $newState);
            } catch (LogicException $exception) {
                throw new LogicException('L\'article ne peut passer au statut'.$newState);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
