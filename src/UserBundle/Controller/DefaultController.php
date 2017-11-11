<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserController extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
