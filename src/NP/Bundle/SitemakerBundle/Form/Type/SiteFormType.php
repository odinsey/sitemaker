<?php

namespace NP\Bundle\SitemakerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
	$builder->add('name', 'text', array('label' => 'Nom du site'));
	
	if ($options['data']->getFolder()) {
	    $builder->add('folder', 'text', array('label' => 'Nom du dossier', 'attr' => array('readonly' => 'readonly')));
	} else {
	    $builder->add('folder', 'text', array('label' => 'Nom du dossier'));
	}
	
	$builder
		->add('email', 'email', array('label' => 'Courriel'))
		->add('logo_file', 'file', array('label' => 'Logo', 'required' => false, 'mapped'=>false));
	
	if ($options['data']->getLogo()) {
	    $builder->add('logo_url', 'image', array('label' => ' '));
	}
	
	$builder->add('image_header_file', 'file', array('label' => 'Entete', 'required' => false, 'mapped'=>false));
	if ($options['data']->getImageHeader()) {
	    $builder->add('header_url', 'image', array('label' => ' '));
	}
	
	$builder
		->add('baseline', 'textarea', array('label' => 'Slogan'))
		->add('favicon_file', 'file', array('label' => 'Favicon', 'required' => false, 'mapped'=>false))
		->add('footer','text')
		->add('bando', 'text', array('label' => 'Bandeau','attr' => array('class' => 'colorpicker')));

	if ($options['data']->getPages()->count()) {
	    setcookie('WEB_UPLOAD_DIR', pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_DIRNAME).'/'.$options['data']->getFolder().'/upload/', time()+36000, '/' );
	    
	    $builder->add('pages', 'collection', array(
		'type' => new PageFormType(),
		'allow_add' => true,
		'allow_delete' => true,
		'by_reference' => false,
		'attr' => array('class' => 'page-collections'),
		//label for each team form type
		'options' => array(
		    'attr' => array('class' => 'page-collection')
		)
	    ));
	}
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	$resolver->setDefaults(array(
	    'data_class' => 'NP\Bundle\SitemakerBundle\Entity\Site',
		'cascade_validation' => true
	));
    }

    public function getName() {
		return 'np_sitemaker_site';
    }

}
