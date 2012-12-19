<?php

namespace NP\Bundle\SitemakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use NP\Bundle\SitemakerBundle\Util\Urlizer;

/**
 * NP\Bundle\SitemakerBundle\Entity\Page
 *
 * @ORM\Table(
 *     name="Page",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(columns={"menu_title","site_id", "sitemap_id"}),
 *     })
 * @ORM\Entity(repositoryClass="NP\Bundle\SitemakerBundle\Entity\PageRepository")
 * @UniqueEntity(fields={"menu_title","site", "sitemap"})
 */
class Page {

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class'=>'NP\Bundle\SitemakerBundle\Entity\Page',
		));
	}

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @var string $menu_title
	 *
	 * @ORM\Column(name="menu_title", type="string", length=255)
	 */
	private $menu_title;
	/**
	 * @var string $meta_title
	 *
	 * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
	 */
	private $meta_title;
	/**
	 * @var string $meta_description
	 *
	 * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
	 */
	private $meta_description;
	/**
	 * @var string $content
	 *
	 * @ORM\Column(name="content", type="text", nullable=true)
	 */
	private $content;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Sitemap", inversedBy="pages")
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	protected $sitemap;
	
    /**
     * @var Site
     * 
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="pages")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $site;

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Set menu_title
	 *
	 * @param string $menuTitle
	 * @return Page
	 */
	public function setMenuTitle($menuTitle) {
		$this->menu_title = $menuTitle;

		return $this;
	}

	/**
	 * Get menu_title
	 *
	 * @return string 
	 */
	public function getMenuTitle() {
		return $this->menu_title;
	}

	/**
	 * Set meta_title
	 *
	 * @param string $metaTitle
	 * @return Page
	 */
	public function setMetaTitle($metaTitle) {
		$this->meta_title = $metaTitle;

		return $this;
	}

	/**
	 * Get meta_title
	 *
	 * @return string 
	 */
	public function getMetaTitle() {
		return $this->meta_title;
	}

	/**
	 * Set meta_description
	 *
	 * @param string $metaDescription
	 * @return Page
	 */
	public function setMetaDescription($metaDescription) {
		$this->meta_description = $metaDescription;

		return $this;
	}

	/**
	 * Get meta_description
	 *
	 * @return string 
	 */
	public function getMetaDescription() {
		return $this->meta_description;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 * @return Page
	 */
	public function setContent($content) {
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string 
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set Sitemap
	 *
	 * @param \NP\Bundle\SitemakerBundle\Entity\Sitemap $sitemap
	 */
	public function setSitemap(Sitemap $sitemap = null) {
		$this->sitemap = $sitemap;
	}

	/**
	 * Get Sitemap
	 *
	 * @return \NP\Bundle\SitemakerBundle\Entity\Sitemap
	 */
	public function getSitemap() {
		return $this->sitemap;
	}

	/**
	 * Set Site
	 * 
	 * @param \NP\Bundle\SitemakerBundle\Entity\Site $site
	 * @return Page
	 */
	public function setSite(Site $site = null) {
		$this->site = $site;
	}

	/**
	 * @param \NP\Bundle\SitemakerBundle\Entity\Site $site
	 * @return Site
	 */
	public function getSite() {
		return $this->site;
	}
	
	public function getFolder() {
		return $this->getSite()->getFolder();
	}
	
	/*
	 * get url of the page
	 * 
	 * @return string
	 */
	public function getUrl() {
		return $this->getSitemap() ? Urlizer::urlize($this->getSitemap()->getName().'_'.$this->getMenuTitle()).'.php' : Urlizer::urlize($this->getMenuTitle()).'.php';
	}

}
