<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Model\PaginationDTO;
use App\Model\Paginator;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

final class MoviesController extends AbstractController
{
#[Route('/movies', name: 'app_movies', methods: ['GET'])]
public function index(
    MovieRepository $movieRepository,
    #[MapQueryString] PaginationDTO $paginationDTO
): JsonResponse {
    $query = $movieRepository->createQueryBuilder('m');

    if ($paginationDTO->title !== null) {
    $query->andWhere('LOWER(m.title) LIKE LOWER(:title)')
        ->setParameter('title', '%' . $paginationDTO->title . '%');
}

    if ($paginationDTO->year !== null) {
        $query->andWhere('m.year = :year')
            ->setParameter('year', $paginationDTO->year);
}

    $paginator = (new Paginator())->paginate($query, $paginationDTO);

    return $this->json(
        $paginator,
        Response::HTTP_OK,
        [],
        ['groups' => ['paginate', 'movie:read']]
    );
}
#[Route('/movies', name: 'app_movies_create', methods: ['POST'])]
public function create(
    EntityManagerInterface $entityManager,
    #[MapRequestPayload(
        serializationContext: ['groups' => ['movie:write']],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY,
    )]
    Movie $movie
): JsonResponse {
    $entityManager->persist($movie);
    $entityManager->flush();

    return $this->json(
        $movie,
        Response::HTTP_CREATED,
        [],
        ['groups' => ['movie:read']]
    );
}

#[Route('/movies/{id}', name: 'app_movies_update', methods: ['PUT'])]
public function update(
    int $id,
    Request $request,
    MovieRepository $movieRepository,
    EntityManagerInterface $entityManager
): JsonResponse {
    $movie = $movieRepository->find($id);

    if (!$movie) {
        throw $this->createNotFoundException('Movie not found');
    }

    $data = json_decode($request->getContent(), true);

    $movie->setTitle($data['title']);
    $movie->setDescription($data['description']);
    $movie->setYear($data['year']);

    $entityManager->flush();

    return $this->json($movie, Response::HTTP_OK, [], ['groups' => ['movie:read']]);
}

#[Route('/movies/{id}', name: 'app_movies_delete', methods: ['DELETE'])]
public function delete(
    int $id,
    MovieRepository $movieRepository,
    EntityManagerInterface $entityManager
): JsonResponse {
    $movie = $movieRepository->find($id);

    if (!$movie) {
        throw $this->createNotFoundException('Movie not found');
    }

    $entityManager->remove($movie);
    $entityManager->flush();

    return $this->json(null, Response::HTTP_NO_CONTENT);
}

#[Route('/test', name: 'app_movies_example', methods: ['POST'])]
public function example(
    EntityManagerInterface $entityManager,
    MovieRepository $movieRepository
): JsonResponse {
    $createdMovie = new Movie();
    $createdMovie->setTitle('Inception');
    $createdMovie->setDescription('A thief who steals corporate secrets through dream-sharing technology.');
    $createdMovie->setYear(2010);
    $entityManager->persist($createdMovie);
    $entityManager->flush();
    $movie = $entityManager->getRepository(Movie::class)->find(1);
    $movie = $movieRepository->find(1);
    $movies = $entityManager->getRepository(Movie::class)->findBy(
    ['title' => 'My movie'],
    ['year' => 'DESC']
);


   return $this->json([
    'movie' => $movie,
    'movies' => $movies,
]);
}
}
