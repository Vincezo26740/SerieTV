<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class SerieType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Title'
			])                                              // 1er occurence => nom propriété Serie,
			// 2eme argument => type de champs ::class retourne le nom complet de la classe avec name space,
			// 3éme argument => Tableau associatif d'options cf doc
			->add('overview', null, [
				'required' => false
			])
			->add('status', ChoiceType::class, [
				'choices' => [                                //  liste de choix :
					'Cancelled' => 'Cancelled',
					'Ended' => 'Ended',
					'Returning' => 'Returning'
				],
				'multiple' => false                          // Possibilité du multi-choix
			])
			->add('vote')
			->add('popularity')
			->add('genres')
			->add('firstAirDate', DateType::class, [
				'html5' => true,
				'widget' => 'single_text'
			])
			->add('lastAirDate')
			->add('backdrop')
			->add('poster')
			->add('tmdbId')

			//date gérés programmatiquement donc pas saisie user
			// ->add('dateCreated')
			// ->add('dateModified')
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Serie::class,
		]);
	}
}
