<?php

namespace Cekurte\Pages\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/page/contact');

        $this->assertTrue($crawler->filter('html:contains("Page contact")')->count() > 0);
    }
}
