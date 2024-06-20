<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Entity\MangaUser;
use App\Entity\User;
use App\Repository\MangaRepository;
use App\Repository\MangaUserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/change-collected/{mangaId}/{volume}', name: 'change_collected')]
    public function changeCollected(int $mangaId, int $volume, EntityManagerInterface $em, MangaUserRepository $mangaUserRepository): Response
    {
        $user = $this->getUser();
        $mangaUser = $em->getRepository(MangaUser::class)->findOneBy([
            'user' => $user,
            'manga' => $mangaId,
            'volume_number' => $volume,
        ]);

        if (!$mangaUser) {
            $mangaUser = new MangaUser();
            $mangaUser->setUser($user);
            $mangaUser->setManga($em->getReference(Manga::class, $mangaId));
            $mangaUser->setVolumeNumber($volume);
            $mangaUser->setReaded(false);
        }

        if ($mangaUser->isCollected() === true) {
            $mangaUser->setCollected(false);
            if ($mangaUser->isReaded() === false) {
                $em->remove($mangaUser);
            } else {
                $em->persist($mangaUser);
            }
        } else {
            $mangaUser->setCollected(true);
            $em->persist($mangaUser);
        }

        $em->flush();

        return $this->redirectToRoute('manga_id', ['id' => $mangaId]);
    }

    #[Route('/change-readed/{mangaId}/{volume}', name: 'change_readed')]
    public function changeReaded(int $mangaId, int $volume, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $mangaUser = $em->getRepository(MangaUser::class)->findOneBy([
            'user' => $user,
            'manga' => $mangaId,
            'volume_number' => $volume,
        ]);

        if (!$mangaUser) {
            $mangaUser = new MangaUser();
            $mangaUser->setUser($user);
            $mangaUser->setManga($em->getReference(Manga::class, $mangaId));
            $mangaUser->setVolumeNumber($volume);
            $mangaUser->setCollected(false);
        }

        if ($mangaUser->isReaded() === true) {
            $mangaUser->setReaded(false);
            if ($mangaUser->isCollected() === false) {
                $em->remove($mangaUser);
            } else {
                $em->persist($mangaUser);
            }
        } else {
            $mangaUser->setReaded(true);
            $em->persist($mangaUser);
        }
        $em->flush();

        return $this->redirectToRoute('manga_id', ['id' => $mangaId]);
    }
}
