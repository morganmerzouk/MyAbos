<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * Description of SkipperAdminTest
 *
 * @author Morgan
 */
class SkipperAdminTest extends WebTestCase {
 
    protected $urlList = "/admin/skipper/list";
    protected $urlAdd = "/admin/skipper/add";
    protected $urlEdit = "/admin/skipper/edit";
    
    public function testAddSkipper()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->urlAdd);
        
        $form = $crawler->selectButton('submit')->form();        
        $form['name']= "destination name";
        $form['description'] = "my description";
        $form['linkgmap'] = "http://www.maps.google.com?id=3&country=2";
        $form['published'] = "1";
        $crawler = $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect($this->urlList));
        $this->GreaterThan(0, $crawler->filter('a:contains("destination name")')->count());
    }
    
    public function testEditSkipper()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->urlList);
        //Cliquer sur le lien d'edit
        $form = $crawler->selectButton('submit')->form();        
        $form['name']= "new destination name";
        $form['description'] = "my description";
        $form['linkgmap'] = "http://www.maps.google.com?id=3&country=2";
        $form['published'] = "1";
        $crawler = $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect($this->urlList));
        $this->GreaterThan(0, $crawler->filter('a:contains("new destination name")')->count());
    }
    
    public function testDeleteSkipper()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->urlList);
        //Cliquer sur le lien de suppression
        $form = $crawler->selectButton('submit')->form();        
        $form['name']= "new destination name";
        $crawler = $client->submit($form);
        
        //On est redirigé vers une page intermédiaire
        $this->assertTrue($client->getResponse()->isRedirect($this->urlList));
        $this->GreaterThan(0, $crawler->filter('a:contains("new destination name")')->count());
    }
}
