<?php

namespace NP\Bundle\SitemakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NP\Bundle\SitemakerBundle\Entity\Sitemap
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NP\Bundle\SitemakerBundle\Entity\SitemapRepository")
 */
class Sitemap {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var string $name
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;
	
	/**
	 * @var \NP\Bundle\SitemakerBundle\Entity\Pages[] $pages
	 * 
	 * @ORM\OneToMany(targetEntity="Page", mappedBy="sitemap", cascade={"all"}, orphanRemoval=true)
	 */
	protected $pages;

	public function __construct() {
		$this->pages = new ArrayCollection();
	}

	public function __toString() {
		return $this->name;
	}

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return \NP\Bundle\SitemakerBundle\Entity\Sitemap
	 */
	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string 
	 */
	public function getName() {
		return $this->name;
	}
    
    /**
     * Add Page
     *
     * @param \NP\Bundle\SitemakerBundle\Entity\Page $page
     */
    public function addPage(Page $page) {
		if (!$this->pages->contains($page)) {
			$page->setSitemap($this);
			$this->pages->add($page);
		}
    }

    /**
     * Remove page
     *
     * @param \NP\Bundle\SitemakerBundle\Entity\Page $page
     */
    public function removePage(Page $page) {
		if ( $this->pages->contains($page) ) {
			$this->pages->removeElement($page);
		}
    }
	/**
	 * get pages
	 *
	 * @return ArrayCollection $pages
	 */
	public function getPages() {
		return $this->pages;
	}

}
