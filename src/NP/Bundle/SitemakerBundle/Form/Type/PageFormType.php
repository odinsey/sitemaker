<?php

namespace NP\Bundle\SitemakerBundle\Form\Type;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder,array $options) {
		$builder
				->add('id', 'hidden')
				->add('menu_title',null,array('label'=>'Nom de la page'))
				->add('meta_title',null,array('label'=>'Balise meta title'))
				->add('meta_description',null,array('label'=>'Balise meta description'))
				->add('content','richeditor',array('label'=>'Contenu de la page'))
				->add('sitemap',null,array('label'=>'Sous menu de :'));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class'=>'NP\Bundle\SitemakerBundle\Entity\Page',
		));
	}

	public function getName() {
		return 'np_sitemaker_site';
	}

}
