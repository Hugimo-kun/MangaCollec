<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Editor;
use App\Entity\Manga;
use App\Entity\MangaUser;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NAME_CATEGORY = ["Action", "Fantaisie", "Romance", "Slice of Life", "Aventure", "Horreur", "Comedie", "Science Fiction", "Drama", "Pas définie"];
    private const NAME_EDITOR = ["Shueisha", "Kodansha", "Shogakukan", "Hakusensha", "Square Enix", "Pas définie"];
    private const NAME_STATUS = ["Terminé", "En cours", "Pas commencé"];
    private const NAME_AUTHOR = ["Eiichiro Oda", "Hajime Isayama", "Karuho Shiina", "Chica Umino", "Hiromu Arakawa", "Yoshihiro Togashi", "Shuzo Oshimi", "Kiyohiko Azuma", "Natsuki Takaya", "Atsushi Ōkubo", "Hirohiko Araki", "Katsuhiro Otomo", "Naoki Urasawa", "Yoshiki Nakamura", "Yana Toboso", "Kohei Horikoshi", "Hiro Mashima", "Rumiko Takahashi", "Mizuho Kusanagi", "Shinobu Ohtaka", "Masashi Kishimoto", "Yukito Kishiro", "Toru Fujisawa", "Ai Yazawa", "Jun Mochizuki", "Akira Toriyama", "Hitoshi Iwaaki", "Tetsu Kariya", "Bisco Hatori", "Kazue Kato", "Yoko Kamio", "Nakaba Suzuki", "Naoki Urasawa", "Kentaro Miura", "Satsuki Yoshino"];
    private const NUMBER_VOLUME_AOT = 6;
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    private function JSONTranslate($file)
    {
        $filename = __DIR__ . '/' . $file;
        echo $filename;

        if (!file_exists($filename)) {
            echo "Erreur : le fichier n'existe pas.";
            return null;
        }

        $fileContent = file_get_contents($filename);
        if ($fileContent === false) {
            echo "Erreur : impossible de lire le fichier.";
            return null;
        }

        $data = json_decode($fileContent, true);
        if ($data === null) {
            echo "Erreur : échec du décodage JSON.";
            return null;
        }

        return $data;

    }
    public function load(ObjectManager $manager): void
    {

        $arrayCategory = [];

        foreach (self::NAME_CATEGORY as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $arrayCategory[$categoryName] = $category;
        }

        $arrayEditor = [];

        foreach (self::NAME_EDITOR as $editorName) {
            $editor = new Editor();
            $editor->setName($editorName);
            $manager->persist($editor);
            $arrayEditor[$editorName] = $editor;
        }

        $arrayStatus = [];

        foreach (self::NAME_STATUS as $statusName) {
            $status = new Status();
            $status->setName($statusName);
            $manager->persist($status);
            $arrayStatus[$statusName] = $status;
        }

        $arrayAuthor = [];

        foreach (self::NAME_AUTHOR as $authorName) {
            $author = new Author();
            $author->setFullName($authorName);
            $manager->persist($author);
            $arrayAuthor[$authorName] = $author;
        }

        $data = $this->JSONTranslate('manga.json');
        foreach ($data as $value) {
            $manga = new Manga();
            $releaseDate = new \DateTime($value['release_date']);
            $manga
                ->setTitle($value['title'])
                ->setVolumes($value['volumes'])
                ->setCoverImage($value['cover_image'])
                ->setReleaseDate($releaseDate);
            if (isset($arrayCategory[$value["category"]])) {
                $manga->setCategory($arrayCategory[$value["category"]]);
            }
            if (isset($arrayEditor[$value["editor"]])) {
                $manga->setEditor($arrayEditor[$value["editor"]]);
            }
            if (isset($arrayStatus[$value["status"]])) {
                $manga->setStatus($arrayStatus[$value["status"]]);
            }
            if (isset($arrayAuthor[$value["author"]])) {
                $manga->setAuthor($arrayAuthor[$value["author"]]);
            }
            $manager->persist($manga);
            $mangaChoose[] = $manga;
        }

        $user1 = new User();
        $user1
            ->setEmail("user@mangacollec.com")
            ->setPassword("quoicoubeh");

        $manager->persist($user1);

        $user2 = new User();
        $user2
            ->setEmail("admin@mangacollec.com")
            ->setPassword("bobby")
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user2);

        for ($i = 0; $i < self::NUMBER_VOLUME_AOT; $i++) {
            $mangaUser = new MangaUser();
            $mangaUser
                ->setUser($user1)
                ->setManga($mangaChoose[11])
                ->setVolumeNumber($i)
                ->setCollected(true)
                ->setReaded(true);

            $manager->persist($mangaUser);
        }

        $manager->flush();
    }
}
