<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}