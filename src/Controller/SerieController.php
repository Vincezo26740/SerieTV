<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
	#[Route('/', name: 'list')]
	public function list(SerieRepository $serieRepository): Response
	{
		//création de requêtes personalisées dans le repository $SerieRepository (acces direct ctrl+maj)
		$series = $serieRepository->findBestSeries();
		//$series = $serieRepository->findAll(); // bien pour tout trouver mais pa possibilité de trier etc donc solution :
		//$series = $serieRepository->findBy([], ['name' => 'DESC', 'popularity' => 'ASC '], 50, 0);
		// [] tableau vide fait pareil q'un find all,
		// [paramtre de tries]
		// limite de nombre afichés
		// début de l'affichage ou offset
		//dd($series); // récupération de toute la table mais pas présenté

		//todo : aller chercher les séries en BDD
		//pour avoir accès au repository, il faut le passer en arguments

		return $this->render('serie/list.html.twig', [
			// Passage du nom du controler, pas interessant 'controller_name' => 'SerieController',
			// passage du tableau $series pour affichage dans le twig
			"series" => $series // affichage par boucle dans list.html.twig dans le body
		]);
	}

	#[Route('/details/{id}', name: 'details')]
	public function details(int $id, SerieRepository $serieRepository): Response
	{
		//todo : aller chercher le détails de la série en BDD
		$serie = $serieRepository->find($id);
		if (!$serie){
			throw $this->createNotFoundException(' Serie inexistante !! ');
		}
		return $this->render('serie/details.html.twig', ["serie" => $serie]);
	}

	#[Route('/create', name: 'create')]
	public function create(Request                $request,
	                       EntityManagerInterface $entityManager): Response
	{
		//todo : formulaire pour création de la série en BDD
		$serie = new Serie();//création de l'insantance de l'entité
		$serie->setDateCreated(new \DateTime());
		$serieForm = $this->createForm(SerieType::class, $serie);//Création de l'instance du type de formulaire
//ttt du formulaire
		$serieForm->handleRequest($request);
		if ($serieForm->isSubmitted() && $serieForm->isValid()) { // contrôle de soumission et contrôle de validité
			$entityManager->persist($serie);
			$entityManager->flush();
			$this->addFlash('success', 'Insertion Parfaite de la nouvelle Serie !!');
			return $this->redirectToRoute('serie_details', ['id' => $serie->getId()]);
		}
		return $this->render('serie/create.html.twig', ['serieForm' => $serieForm->createView()]); // ne pas oublier le createView sinon erreur d'affichage
	}

	/**
	 * @Route ("/delete/{id}",name="delete")
	 */
	public function delete($id, EntityManagerInterface $entityManager): Response
	{
		$serie = $entityManager->find($id);
		$entityManager->remove($serie);
		$entityManager->flush();
		return $this->redirectToRoute('serie_list');
	}

	/**
	 * @Route ("/demo",name="em-demo")
	 */
	public function demo(EntityManagerInterface $entityManager): Response
	{
		//test insertion données
		$serie = new Serie();
		//hydratation (appel des setter)
		$serie->setName('pif');
		$serie->setBackdrop('dasfd');
		$serie->setPoster('dafsdf');
		$serie->setDateCreated(new \DateTime);
		$serie->setFirstAirDate(new \DateTime("- 1 year"));
		$serie->setLastAirDate(new \DateTime("-6 month"));
		$serie->setGenres("Drama");
		$serie->setOverview('sfgsgg');
		$serie->setPopularity(123.00);
		$serie->setVote(8.2);
		$serie->setStatus('canceled');
		$serie->setTmdbId(329432);
		$serie->setdateModified(new \DateTime("+1 hour"));

		dump($serie);

		$entityManager->persist($serie);
		$entityManager->flush();

		dump($serie);

		$serie->setGenres('comedy');

		//$entityManager->remove($serie);
		$entityManager->flush();
		dump($serie);

		return $this->render('serie/create.html.twig');
	}
}
