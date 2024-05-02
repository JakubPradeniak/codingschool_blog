<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    #[Route('/prispevky/{slug}', name: 'app_posts')]
    public function index(CategoryRepository $categoryRepository, string $slug = ''): Response
    {
        if ($slug) {
            $category = $categoryRepository->findOneBy(['slug' => $slug]);
            $posts = $this->postRepository->findBy(['category' => $category], ['id' => 'DESC']);
        } else {
            $posts = $this->postRepository->findBy([], ['id' => 'DESC']);
        }

        dump($posts);

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
