<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Utils\PaginationData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    #[Route('/prispevky/{slug}', name: 'app_posts')]
    public function index(Request $request, CategoryRepository $categoryRepository, string $slug = ''): Response
    {
        if ($slug) {
            $category = $categoryRepository->findOneBy(['slug' => $slug]);
        }

        $page = max(1, $request->query->getInt('page', 1));
        $offset = ($page - 1) * PostRepository::POSTS_PER_PAGE;
        $paginator = $this->postRepository->getPaginatior($category ?? null, $offset);
        $paginationData = new PaginationData(PostRepository::POSTS_PER_PAGE, count($paginator), $page);

        return $this->render('post/index.html.twig', [
            'category' => $category ?? null,
            'posts' => $paginator,
            'pagination_data' => $paginationData,
        ]);
    }
}
