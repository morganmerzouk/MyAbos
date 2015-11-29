<?php
namespace App\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PaymentSuite\StripeBundle;

class PaymentController extends Controller
{

    public function indexAction(Request $request, $id)
    {
        // Vérifier que l'utilisateur a le droit de supprimer ce contrat
        
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        $request = $this->container->get('request');
        $message = '';
        \Stripe::setApiKey('sk_test_GyiB2fCxy62ydudovWhyyp6H');
        
        $token = $request->get('stripeToken');
        
        $customer = \Stripe_Customer::create(array(
            'email' => 'customer@example.com',
            'card' => $token
        ));
        
        $charge = \Stripe_Charge::create(array(
            'customer' => $customer->id,
            'amount' => 12.99,
            'currency' => 'eur'
        ));
        
        $message = '<h1>Paiement effectué avec succès</h1>';
    }
}