<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/season', name: 'season_')]
class SeasonController extends AbstractController
{
	#[Route('/create', name: 'create')]
	public function create(Request $request, EntityManagerInterface $entityManager): Response
	{
		$season = new Season;
		$seasonForm = $this->createForm(SeasonType::class, $season);
		$seasonForm->handleRequest($request);

		if ($seasonForm->isSubmitted() && $seasonForm->isValid()) {
			$entityManager->persist($season);
			$entityManager->flush();

		}

		return $this->render('season/create.html.twig', [
			'seasonForm' => $seasonForm->createView()
		]);
	}

	#[Route('/delete/{id}', name: 'delete')]
	public function delete($id, EntityManagerInterface $entityManager): Response
	{
		$serie = $entityManager->find($id);
		$entityManager->remove($serie);
		$entityManager->flush();

		return $this->redirectToRoute('serie_list');
	}
}
