<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Arta;
use App\Entity\Cazare;
use App\Entity\Favorite;
use App\Entity\MancareBautura;
use App\Entity\MonumenteIstorice;
use App\Entity\MonumenteIstoriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    #[Route(
        path: '/toggle/favorite',
        name: 'app_toggle_favorite',
        methods: ['POST'],
    )]
    public function index(Request $request): JsonResponse
    {
        $favoriteRepository = $this->doctrineRepositoryGetter->getRepository(Favorite::class);
        $id = $request->get('id');
        $type = $request->get('type');
        if (!$this->getUser()) {
            new JsonResponse([
                'status' => 'failed',
                'mesagge' => 'Utilizator nelogat, nu este permis accesul.',
            ]);
        }
        if ($type === 'monument') {
            $findByKey = 'idMonumenteIstorice';
            $subject = $this->doctrineRepositoryGetter
                ->getRepository(MonumenteIstorice::class)
                ->find($id);
        } elseif ($type === 'arta') {
            $findByKey = 'idArta';
            $subject = $this->doctrineRepositoryGetter
                ->getRepository(Arta::class)
                ->find($id);
        } elseif ($type === 'mancare') {
            $findByKey = 'idMancareBautura';
            $subject = $this->doctrineRepositoryGetter
                ->getRepository(MancareBautura::class)
                ->find($id);
        } elseif ($type === 'cazare') {
            $findByKey = 'idCazare';
            $subject = $this->doctrineRepositoryGetter
                ->getRepository(Cazare::class)
                ->find($id);
        } else {
            $findByKey = '';
            $subject = null;
            $status = 'fail';
            $message = 'Ai accesat aceasta resursa pentru un tip nepotrivit';
        }
        $entityId = null;
        if ($findByKey) {
            $favorite = $favoriteRepository->findOneBy([
                $findByKey => $subject,
                'idUser' => $this->getUser(),
            ]);
            $status = 'success';
            if ($favorite) {
                $message = 'Am sters de la favorite.';
                $this->entityManager->remove($favorite);
                $this->entityManager->flush();
            } else {
                $message = 'Am adaugat la favorite.';
                $favorite = new Favorite();
                $favorite->setIdUser($this->getUser());
                $favorite->{'set' . ucfirst($findByKey)}($subject);
                $this->entityManager->persist($favorite);
                $this->entityManager->flush();
                $entityId = $favorite->getIdFavorite();
            }
        }

        return new JsonResponse([
            'status' => $status,
            'mesagge' => $message,
            'entityId' => $entityId,
        ]);
    }

}
