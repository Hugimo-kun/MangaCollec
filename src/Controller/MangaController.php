<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Entity\User;
use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;

class MangaController extends AbstractController
{
    #[Route('/manga', name: 'manga_all')]
    public function listeManga(MangaRepository $mangaRepository): Response
    {
        $mangas = $mangaRepository->findBy([], ['title' => 'asc']);
        return $this->render('manga/all.html.twig', [
            'mangas' => $mangas
        ]);
    }

    #[Route('manga/{id}', name: 'manga_id')]
    public function showManga(Manga $manga): Response
    {
        return $this->render('manga/item.html.twig', [
            'manga' => $manga,
        ]);
    }

    #[Route('utilisateur/manga', name: 'user_manga')]
    public function listMyManga(MangaRepository $mangaRepository, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $mangas = $mangaRepository->findBy([], ['title' => 'asc']);

        return $this->render('user/all.html.twig', [
            'mangas' => $mangas
        ]);
    }
}
