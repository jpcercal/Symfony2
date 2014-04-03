<?php

namespace Cekurte\Custom\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CekurteCustomUserBundle extends Bundle
{
    public function getParent()
    {
        return 'CekurteUserBundle';
    }
}
