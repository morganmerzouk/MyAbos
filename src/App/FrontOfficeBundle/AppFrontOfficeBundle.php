<?php
namespace App\FrontOfficeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppFrontOfficeBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
