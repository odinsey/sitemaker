<?php 

namespace NP\Bundle\SitemakerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use NP\Bundle\SitemakerBundle\Entity\Sitemap;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sitemap = new Sitemap();
        $sitemap->setName('entreprise');
		
        $sitemap2 = new Sitemap();
        $sitemap2->setName('particulier');
		
        $sitemap3 = new Sitemap();
        $sitemap3->setName('installateur');

        $manager->persist($sitemap);
        $manager->persist($sitemap2);
        $manager->persist($sitemap3);
        $manager->flush();
    }
}
