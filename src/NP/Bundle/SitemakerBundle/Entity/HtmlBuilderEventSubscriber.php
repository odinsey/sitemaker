<?php

namespace NP\Bundle\SitemakerBundle\Entity;

use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Common\EventSubscriber;
use NP\Bundle\SitemakerBundle\Util\Urlizer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HtmlBuilderEventSubscriber implements EventSubscriber {

    /**
     * @var ContainerInterface
     */
    private $container;
    protected $path;
    protected $webdir;
    protected $template;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
	$this->container = $container;
    }

    public function getSubscribedEvents() {
	return array(
	    Events::preRemove, //Page::preRemove, Site::preRemove
	    Events::postPersist, //Site::postPersist
	    Events::postUpdate, //Site::postUpdate, Page::postUpdate
	    Events::preUpdate, //Page::preUpdate
	);
    }

    public function preRemove(LifecycleEventArgs $args) {
	$entity = $args->getEntity();
	if ($entity instanceof Page) {
	    $this->webdir = realpath($this->container->get('kernel')->getRootDir() . '/../web') . '/';
	    $this->path = $this->webdir . $entity->getSite()->getFolder();
	    $filesystem = new Filesystem();
	    $filesystem->remove($this->path . '/' . $entity->getUrl());
	} elseif ( $entity instanceof Site && $entity->getFolder() ) {
	    $fs = new Filesystem();
	    $fs->remove(realpath($this->container->get('kernel')->getRootDir() . '/../web/' . $entity->getFolder()));
	}
    }

    public function preUpdate(PreUpdateEventArgs $args) {
	$entity = $args->getEntity();
	if (
	    $entity instanceof Page &&
	    (
	    $args->hasChangedField('menu_title') ||
	    $args->hasChangedField('sitemap')
	    )
	) {
	    $this->webdir = realpath($this->container->get('kernel')->getRootDir() . '/../web') . '/';
	    $this->path = $this->webdir . $entity->getSite()->getFolder();

	    if ($args->hasChangedField('menu_title') && $args->hasChangedField('sitemap')) {
		$old_url = $this->path . '/' . $args->getOldValue('sitemap') . '-' . Urlizer::urlize($args->getOldValue('menu_title'));
	    } elseif ($args->hasChangedField('menu_title')) {
		$old_url = $this->path . '/' . $entity->getSitemap() . '-' . Urlizer::urlize($args->getOldValue('menu_title'));
	    } elseif ($args->hasChangedField('sitemap')) {
		$old_url = $this->path . '/' . $args->getOldValue('sitemap') . '-' . Urlizer::urlize($entity->getMenuTitle());
	    }
	    
	    $filesystem = new Filesystem();
	    $filesystem->remove($old_url . '.php');
	    if ( $args->hasChangedField('sitemap') && !count($args->getOldValue('sitemap')->getPages()) ) {
		$filesystem->remove($this->path . '/left-' . $args->getOldValue('sitemap') .'.php');
	    }
	}
    }

    public function postUpdate(LifecycleEventArgs $args) {
	$this->postPersist($args);
    }

    public function postPersist(LifecycleEventArgs $args) {
	$entity = $args->getEntity();
	$em = $args->getEntityManager();

	if (
	    $entity instanceof Page
	    || $entity instanceof Site
	) {
	    $this->webdir = realpath($this->container->get('kernel')->getRootDir() . '/../web') . '/';
	    $this->path = $this->webdir . $entity->getFolder();
	    $this->template = \file_get_contents($this->webdir . 'skeleton/index.php');
	}
	if ($entity instanceof Page) {
	    $this->generatePage($entity, $em);	    
	    $this->generateLeftMenus($entity->getSite(), $em);
	}
	if ($entity instanceof Site) {
	    if ($entity->getPages()->count() == 0) {
		foreach (array(
		'index',
		'contact',
		'mentions',
		'entreprise',
		'particulier',
		'installateur',
		'callback',
		'qui-sommes-nous'
		) as $page_name) {
		    $page = new Page();
		    $page->setSite($entity);
		    $page->setMenuTitle($page_name);
		    $em->persist($page);
		    $this->generatePage($page, $em);
		}
		$em->flush();
	    }else{
		foreach( $entity->getPages() as $page  ){
		    $this->generatePage($page,$em);
		}
	    }
	    $this->generatePageMailer($entity);
	    $this->generateCss($entity);
	}
    }

    protected function generatePage(Page $page, EntityManager $em) {
	$site = $page->getSite();
	$page_name = Urlizer::urlize($page->getMenuTitle());
	$file = \str_replace(array(
	    '##META_TITLE##',
	    '##META_DESCRIPTION##',
	    '##LOGO##',
	    '##SITENAME##',
	    '##BASELINE##',
	    '##PAGENAME##',
	    '##CONTENT##',
	    '##FOOTER##'
	    ), array(
	    $page->getMetaTitle(),
	    $page->getMetaDescription(),
	    $site->getLogo(),
	    $site->getName(),
	    nl2br($site->getBaseline()),
	    $page->getSitemap() ? $page->getSitemap()->getName() : $page_name,
	    \file_exists($this->webdir . 'skeleton/' . $page_name . '_part.php') ? \file_get_contents($this->webdir . 'skeleton/' . $page_name . '_part.php') : $page->getContent(),
	    $site->getFooter()
	    ), $this->template);

	$this->generateLeftMenus($site,$em);
	
	if (
	    !\file_put_contents($this->path . '/' . $page->getUrl(), $file)
	) {
	    throw new \Exception('Failure on file_put_contents on ' . $this->path . '/' . $page->getUrl());
	}
    }

    protected function generateLeftMenus(Site $site, EntityManager $em){
	$left_sitemaps = $em->getRepository('NP\Bundle\SitemakerBundle\Entity\Sitemap')->findAll();
	foreach( $left_sitemaps as $left_sitemap ){
	    $this->generateLinkList($left_sitemap, $site, $em);
	}
    }
    
    protected function generateLeftMenu(Page $page, EntityManager $em, $page_name = null) {
	$left_sitemap = $em->getRepository('NP\Bundle\SitemakerBundle\Entity\Sitemap')->findBy(array('name' => $page_name ? $page_name : $page->getSitemap()->getName()));
	$this->generateLinkList($left_sitemap, $page->getSite(), $em);
    }

    protected function generateLinkList(Sitemap $sitemap, Site $site, EntityManager $em){
	$left_pages = $em->getRepository('NP\Bundle\SitemakerBundle\Entity\Page')->findBy(array('sitemap' => $sitemap, 'site' => $site));
	if( $left_pages && count($left_pages) ){
	    $link_list = '<nav><span class="title">' . $sitemap->getName() . '</span>';
	    foreach ($left_pages as $page) {
		$link_list .= '<a href="' . $page->getUrl() . '" title="' . $page->getMenuTitle() . '">' . $page->getMenuTitle() . '</a>';
	    }
	    $link_list .= '</nav>';
	    if (
		!\file_put_contents($this->path . '/left_' . $sitemap->getName() . '.php', $link_list)
	    ) {
		throw new \Exception('Failure on file_put_contents on ' . $this->path . '/left_' . $sitemap->getName() . '.php');
	    }
	}else{	    
	    $filesystem = new Filesystem();
	    $filesystem->remove($this->path.'/left-'.$sitemap->getName().'.php');
	}
    }
    
    protected function generatePageMailer(Site $site) {
	$page_name = Urlizer::urlize('mailer');
	$file = \str_replace(array(
	    '##META_TITLE##',
	    '##LOGO##',
	    '##SITENAME##',
	    '##BASELINE##',
	    '##PAGENAME##',
	    '##CONTENT##',
	    '##FOOTER##'
	    ), array(
	    "Contact",
	    $site->getLogo(),
	    $site->getName(),
	    nl2br($site->getBaseline()),
	    '',
	    \file_exists($this->webdir . 'skeleton/' . $page_name . '_part.php') 
		? \str_replace(array("##EMAIL##", "##SITENAME##"), array($site->getEmail(), $site->getName()), \file_get_contents($this->webdir . 'skeleton/' . $page_name . '_part.php')) 
		: '',
	    $site->getFooter()
	    ), $this->template);
	if (
	    !\file_put_contents($this->path . '/' . $page_name . '.php', $file)
	) {
	    throw new \Exception('Failure on file_put_contents on ' . $this->path . '/' . $page_name . '.php');
	}
    }

    protected function generateCss(Site $site) {
	$css = \file_get_contents($this->webdir . 'skeleton/css/structure.css');
	$file = \str_replace(array(
	    '##BG_SITE_1##',
	    '##BG_SITE_2##',
	    '##IMAGE_HEADER##',
	    '##BANDO##',
	    '##BG_LEFT_1##',
	    '##BG_LEFT_2##',
	    '##LINK_LEFT##'
	    ), array(
	    $site->getBgSite1(),
	    $site->getBgSite2(),
	    $site->getImageHeader(),
	    $site->getBando(),
	    $site->getBgLeft1(),
	    $site->getBgLeft2(),
	    $site->getLinkLeft()
	    ), $css);
	if (
	    !\file_put_contents($this->path . '/css/structure.css', $file)
	) {
	    throw new \Exception('Failure on file_put_contents on ' . $this->path . '/css/structure.css');
	}
    }

}
