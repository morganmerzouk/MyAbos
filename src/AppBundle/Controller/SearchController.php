<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SearchHeaderType;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

    protected $results;

    public function searchHeaderAction()
    {
        $locale = $this->getRequest()->getLocale();
        $session = $this->getRequest()->getSession();
        $form = $this->createForm(new SearchHeaderType($this->getDoctrine()
            ->getManager(), $locale));
        
        $dateDepart = $session->get('dateDepart');
        $dateRetour = $session->get('dateRetour');
        $prestation = $session->get('prestation');
        $destination = $session->get('destination');
        $nbPassager = $session->get('nbPassager');
        
        $values = array();
        
        if ($session->get('dateDepart') != null)
            $values['dateDepart'] = $session->get('dateDepart');
        if ($session->get('dateRetour') != null)
            $values['dateRetour'] = $session->get('dateRetour');
        if ($session->get('prestation') != null)
            $values['prestation'] = $session->get('prestation');
        if ($session->get('destination') != null)
            $values['destination'] = $session->get('destination');
        if ($session->get('nbPassager') != null)
            $values['nbPassager'] = $session->get('nbPassager');
        
        $form->setData($values);
        
        return $this->render('AppBundle:Front:form/search_header.html.twig', array(
            'form' => $form->createView(),
            'locale' => $locale
        ));
    }

    /**
     * @Route("/search_results", name="search_results")
     */
    public function searchResultAction(Request $request)
    {
        $locale = $this->getRequest()->getLocale();
        
        $form = $this->createForm(new SearchHeaderType($this->getDoctrine()
            ->getManager(), $locale));
        
        $form->handleRequest($request);
        $this->results = null;
        if ($form->isValid()) {
            $data = $form->getData();
            
            $session = $this->getRequest()->getSession();
            $session->set('dateDepart', $data['dateDepart']);
            $session->set('dateRetour', $data['dateRetour']);
            $session->set('prestation', $data['prestation']);
            $session->set('destination', $data['destination']);
            $session->set('nbPassager', $data['nbPassager']);
            
            $this->querySearchResult("price", "asc");
        }
        return $this->render('AppBundle:Front:Search/search_results.html.twig', array(
            'results' => $this->results
        ));
    }

    /**
     * @Route("/search_result_content/{attr}", name="search_result_content")
     */
    public function searchResultQuery($attr = null)
    {
        $locale = $this->getRequest()->getLocale();
        
        $orderBy = explode('_', $attr)[0];
        $sort = explode('_', $attr)[1];
        
        $this->querySearchResult($orderBy, $sort);
        
        return $this->render('AppBundle:Front:Search/search_results_content.html.twig', array(
            'results' => $this->results
        ));
    }

    public function querySearchResult($orderBy, $sort)
    {
        $results = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle\Entity\Croisiere")
            ->createQueryBuilder('c')
            ->select('c,b,bt,ic,i,t')
            ->join('c.bateau', 'b')
            ->join('b.translations', 'bt')
            ->join('c.dateNonDisponibilite', 'dnd')
            ->join('c.itineraireCroisiere', 'ic')
            ->join('ic.itineraire', 'i')
            ->join('c.translations', 't')
            ->where('t.locale = :locale')
            ->setParameter(':locale', $this->getRequest()
            ->getLocale());
        
        $session = $this->getRequest()->getSession();
        $dateDepart = $session->get('dateDepart');
        $dateRetour = $session->get('dateRetour');
        $destination = $session->get('destination');
        $prestation = $session->get('prestation');
        $nbPassager = $session->get('nbPassager');
        
        if ($dateDepart != null) {
            $results->andWhere('ic.dateDebut < :dateDepart')
                ->andWhere('ic.dateFin > :dateDepart')
                ->setParameter(':dateDepart', $dateDepart->format('Y-m-d'));
        }
        if ($dateRetour != null) {
            $results->andWhere('ic.dateFin > :dateRetour')
                ->andWhere('ic.dateDebut < :dateRetour')
                ->setParameter(':dateRetour', $dateRetour->format('Y-m-d'));
        }
        if ($destination != null) {
            $results->andWhere('i.destination = :destination')->setParameter(':destination', $destination);
        }
        if ($prestation != null) {}
        if ($nbPassager != null) {
            $results->andWhere('b.nbCouchage > :nbPassager')->setParameter(':nbPassager', $nbPassager);
        }
        
        $this->results = $results->orderBy('c.id', $sort)
            ->getQuery()
            ->getResult();
    }
}
