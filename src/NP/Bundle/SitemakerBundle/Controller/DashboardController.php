<?php

namespace NP\Bundle\SitemakerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NP\Bundle\SitemakerBundle\Entity\SitemapRepository;

class DashboardController extends Controller {

	/**
	 * @Route("/", name="homepage")
	 * @Template()
	 */
	public function indexAction() {
		$this->siteList = $this->getDoctrine()->getRepository('NPSitemakerBundle:Site')->findAll();
		return array('sitelist'=>$this->siteList);
	}

}
