<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{/*
	/**
	 * @Route("/",name="main_home")
	 */
	/*public function Home(){
		echo 'Coucou';
		die();
	}
	/**
	 * @Route("/test",name="main_test")
	 */
	/*public function test(){
		echo 'Coucou page test';
		die();
	}*/

		/**
		 * @Route("/",name="main_home")
		 */
	public function Home(){
return $this->render('main/home.html.twig');
	}

		/**
		 * @Route("/test",name="main_test")
		 */
	public function test(){
$serie=["title" =>"Games Of Throne","year"=>2000,];

return $this->render('main/test.html.twig',["mySerie"=>$serie]);
	}

}