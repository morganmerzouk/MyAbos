<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * Description of DestinationAdminTest
 *
 * @author Morgan
 */
class DestinationAdminTest extends WebTestCase {
    
    protected $urlList = "/admin/destination/list";
    protected $urlAdd = "/admin/destination/add";
    protected $urlEdit = "/admin/destination/edit";
    
    public function setUp()
    {
        $this->client = static::createClient();
    }
    
    public function testLoginOk()
    {
        $this->logIn();

        $this->client->request('GET', $this->urlList);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($client->getResponse()->isRedirect('/admin/dashboard'));
    
    }
    
    public function testLoginKo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/dashboard');
        
        $form = $crawler->selectButton('submit')->form();        
        $form['login']= "loginko";
        $form['password'] = "passwordko";
        $crawler = $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect('/admin/login'));
    }
    
    public function testAddDestination()
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
    
    public function testEditDestination()
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
    
    public function testDeleteDestination()
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
    
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
