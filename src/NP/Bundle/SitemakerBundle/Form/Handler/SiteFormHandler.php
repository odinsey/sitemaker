<?php

namespace NP\Bundle\SitemakerBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use NP\Bundle\SitemakerBundle\Util\Urlizer;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\Inflector;
use NP\Bundle\SitemakerBundle\Form\Handler\BaseFormHandler;

class SiteFormHandler extends BaseFormHandler {

	protected $class_name = 'NP\Bundle\SitemakerBundle\Entity\Site';
	protected $request;
	protected $em;
	protected $path;
	protected $webdir;
	protected $template;

	public function __construct(Request $request, EntityManager $em) {
		$this->request = $request;
		$this->em = $em;
	}

	protected function preSave(Form $form,$entity,$controller) {
		//mkdir de $entity->getFolder();
		$this->webdir = realpath($controller->get('kernel')->getRootDir().'/../web').'/';
		$this->path = $this->webdir.$entity->getFolder();
		//Sauvegarde des fichiers images
		$image_dir = sprintf($entity->getImagesPath(),$this->webdir);
		$entity->setFolder(Urlizer::urlize($entity->getFolder()));
		foreach(array('logo','image_header','favicon') as $field){
			if($form[$field.'_file']->getData()){
				$uploaded_file = $form[$field.'_file']->getData();
				if(!is_dir($image_dir)){
					$filesystem = new Filesystem();
					$filesystem->mirror($this->webdir.'skeleton',$this->webdir.$entity->getFolder(),null,array('override'=>true));
				}
				$original_filename = $uploaded_file->getClientOriginalName();
				$uploaded_file->move($image_dir,$original_filename);
				$entity->{Inflector::camelize('set_'.$field)}($original_filename);
			}
		}
	}
}
