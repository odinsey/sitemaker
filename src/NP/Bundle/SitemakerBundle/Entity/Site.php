<?php

namespace NP\Bundle\SitemakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use NP\Bundle\SitemakerBundle\Util\Urlizer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NP\Bundle\SitemakerBundle\Entity\Site
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NP\Bundle\SitemakerBundle\Entity\SiteRepository")
 * @UniqueEntity("folder")
 */
class Site {

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
     * @var string $folder
     *
     * @ORM\Column(name="folder", type="string", length=255, unique=true)
     */
    private $folder;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @var string $image_header
     *
     * @ORM\Column(name="image_header", type="string", length=255)
     */
    private $image_header;

    /**
     * @var string $baseline
     *
     * @ORM\Column(name="baseline", type="text")
     */
    private $baseline;

    /**
     * @var string $favicon
     *
     * @ORM\Column(name="favicon", type="string", length=255, nullable=true)
     * 
     */
    private $favicon;

    /**
     * @var string $footer
     *
     * @ORM\Column(name="footer", type="text")
     */
    private $footer;

    /**
     * @var string $bg_site_1
     *
     * @ORM\Column(name="bg_site_1", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $bg_site_1 = "#242424";

    /**
     * @var string $bg_site_2
     *
     * @ORM\Column(name="bg_site_2", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $bg_site_2 = "#393939";

    /**
     * @var string $bando
     *
     * @ORM\Column(name="bando", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $bando;

    /**
     * @var string $bg_left_1
     *
     * @ORM\Column(name="bg_left_1", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $bg_left_1 = "#2f2f2f";

    /**
     * @var string $bg_left_2
     *
     * @ORM\Column(name="bg_left_2", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $bg_left_2 = "#595959";

    /**
     * @var string $link_left
     *
     * @ORM\Column(name="link_left", type="string", length=255)
     * @Assert\Regex("|#[A-Fa-f0-9]{3,6}|")
     */
    private $link_left = "#cacaca";

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="site", cascade={"all"}, orphanRemoval=true)
     */
    protected $pages;

    public function __construct() {
		$this->pages = new ArrayCollection();
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
     * @return Site
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
     * Set folder
     *
     * @param string $folder
     * @return Site
     */
    public function setFolder($folder) {
	$this->folder = $folder;

	return $this;
    }

    /**
     * Get folder
     *
     * @return string 
     */
    public function getFolder() {
	return $this->folder;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Site
     */
    public function setEmail($email) {
	$this->email = $email;

	return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
	return $this->email;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Site
     */
    public function setLogo($logo) {
	$this->logo = $logo;

	return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo() {
	return $this->logo;
    }

    /**
     * Set image_header
     *
     * @param string $imageHeader
     * @return Site
     */
    public function setImageHeader($imageHeader) {
	$this->image_header = $imageHeader;

	return $this;
    }

    /**
     * Get image_header
     *
     * @return string 
     */
    public function getImageHeader() {
	return $this->image_header;
    }

    /**
     * Set baseline
     *
     * @param string $baseline
     * @return Site
     */
    public function setBaseline($baseline) {
	$this->baseline = $baseline;

	return $this;
    }

    /**
     * Get baseline
     *
     * @return string 
     */
    public function getBaseline() {
	return $this->baseline
	;
    }

    /**
     * Set favicon
     *
     * @param string $favicon
     * @return Site
     */
    public function setFavicon($favicon) {
	$this->favicon = $favicon;

	return $this;
    }

    /**
     * Get favicon
     *
     * @return string 
     */
    public function getFavicon() {
	return $this->favicon;
    }

    /**
     * Set footer
     *
     * @param string $footer
     * @return Site
     */
    public function setFooter($footer) {
	$this->footer = $footer;

	return $this;
    }

    /**
     * Get footer
     *
     * @return string 
     */
    public function getFooter() {
	return $this->footer;
    }

    /**
     * Set bg_site_1
     *
     * @param string $bgSite1
     * @return Site
     */
    public function setBgSite1($bgSite1) {
	$this->bg_site_1 = $bgSite1;

	return $this;
    }

    /**
     * Get bg_site_1
     *
     * @return string 
     */
    public function getBgSite1() {
	return $this->bg_site_1;
    }

    /**
     * Set bg_site_2
     *
     * @param string $bgSite2
     * @return Site
     */
    public function setBgSite2($bgSite2) {
	$this->bg_site_2 = $bgSite2;

	return $this;
    }

    /**
     * Get bg_site_2
     *
     * @return string 
     */
    public function getBgSite2() {
	return $this->bg_site_2;
    }

    /**
     * Set bando
     *
     * @param string $bando
     * @return Site
     */
    public function setBando($bando) {
	$this->bando = $bando;

	return $this;
    }

    /**
     * Get bando
     *
     * @return string 
     */
    public function getBando() {
	return $this->bando;
    }

    /**
     * Set bg_left_1
     *
     * @param string $bgLeft1
     * @return Site
     */
    public function setBgLeft1($bgLeft1) {
	$this->bg_left_1 = $bgLeft1;

	return $this;
    }

    /**
     * Get bg_left_1
     *
     * @return string 
     */
    public function getBgLeft1() {
	return $this->bg_left_1;
    }

    /**
     * Set bg_left_2
     *
     * @param string $bgLeft2
     * @return Site
     */
    public function setBgLeft2($bgLeft2) {
	$this->bg_left_2 = $bgLeft2;

	return $this;
    }

    /**
     * Get bg_left_2
     *
     * @return string 
     */
    public function getBgLeft2() {
	return $this->bg_left_2;
    }

    /**
     * Set link_left
     *
     * @param string $linkLeft
     * @return Site
     */
    public function setLinkLeft($linkLeft) {
		$this->link_left = $linkLeft;

		return $this;
    }

    /**
     * Get link_left
     *
     * @return string 
     */
    public function getLinkLeft() {
		return $this->link_left;
    }

    /**
     * Get pages
     *
     * @return array_collection 
     */
    public function getPages() {
		return $this->pages;
    }

    /**
     * Add page
     *
     * @param \NP\Bundle\SitemakerBundle\Entity\Page $page
     */
    public function addPage(Page $page) {
		if (!$this->pages->contains($page)) {
			$page->setSite($this);
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
     * Get logo_url
     *
     * @return string 
     */
    public function getLogoUrl() {
		return '/' . $this->folder . '/images/' . $this->logo;
    }
    /**
     * Set logo_url
     *
     */
    public function setLogoUrl() {
    }
    /**
     * Get header_url
     *
     * @return string 
     */
    public function getHeaderUrl() {
		return '/' . $this->folder . '/images/' . $this->image_header;
    }
    
    /**
     * Set header_url
     *
     */
    public function setHeaderUrl() {
    }
    
    /**
     * Get favicon_url
     *
     * @return string 
     */
    public function getFaviconUrl() {
		return '/' . $this->folder . '/images/' . $this->favicon;
    }
    /**
     * Set favicon_url
     *
     */
    public function setFaviconUrl() {
    }

    public function getImagesPath() {
		return '%s/' . Urlizer::urlize($this->getFolder()) . '/images/';
    }
    public function getUploadPath() {
		return '%s/' . Urlizer::urlize($this->getFolder()) . '/upload/';
    }

}
