<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Utils\PaginationData;
use App\Utils\ReadingTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\UnicodeString;

class PostController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository,
        private EntityManagerInterface $entityManager
    ) {
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
        $paginationData = new PaginationData(PostRepository::POSTS_PER_PAGE, $paginator->count(), $page);

        return $this->render('post/index.html.twig', [
            'category' => $category ?? null,
            'posts' => $paginator,
            'pagination_data' => $paginationData,
        ]);
    }

    #[Route('/prispevek/{slug}', name: 'app_post')]
    public function show(Request $request, Post $post): Response
    {
        $redingTime = ReadingTime::calculate($post->getContent());

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $post->addComment($comment);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $this->addFlash('success', 'Komentář byl úspěšně vytvořen.');

            return $this->redirectToRoute('app_post', ['slug' => $post->getSlug()]);
        }

        if ($commentForm->isSubmitted() && !$commentForm->isValid()) {
            $this->addFlash('error', 'Komentář se nepodařilo vytvořit. Zkontrojte správnost vyplnených informací.');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'reading_time' => $redingTime,
            'comment_form' => $commentForm,
        ]);
    }

    #[Route('/api/prispevky/{slug}', name: 'api_posts')]
    public function apiIndex(Request $request, CategoryRepository $categoryRepository, string $slug = ''): Response
    {
        if ($slug) {
            $category = $categoryRepository->findOneBy(['slug' => $slug]);
        }

        $page = max(1, $request->query->getInt('page', 1));
        $offset = ($page - 1) * PostRepository::POSTS_PER_PAGE;
        $paginator = $this->postRepository->getPaginatior($category ?? null, $offset);
        $paginationData = new PaginationData(PostRepository::POSTS_PER_PAGE, $paginator->count(), $page);

        $processedPosts = array_map(
            function ($post) {
                $content = (new UnicodeString(strip_tags($post->getContent())))->truncate(80, '...');
                $url = $this->generateUrl('app_post', ['slug' => $post->getSlug()]);
                return [
                    'name' => $post->getName(),
                    'image' => '/images/' . $post->getImage(),
                    'content' => $content,
                    'url' => $url
                ];
            },
            $paginator->getQuery()->getResult()
        );

        return $this->json([
            'posts' => $processedPosts,
            'pagination' => $paginationData
        ]);
    }

    #[Route('/admin/prispevky', name: 'app_posts_admin')]
    public function indexAdmin(Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $offset = ($page - 1) * PostRepository::POSTS_PER_PAGE;
        $paginator = $this->postRepository->getPaginatior(null, $offset);
        $paginationData = new PaginationData(PostRepository::POSTS_PER_PAGE, $paginator->count(), $page);

        return $this->render('post/index_admin.html.twig', [
            'posts' => $paginator,
            'pagination_data' => $paginationData,
        ]);
    }
}
