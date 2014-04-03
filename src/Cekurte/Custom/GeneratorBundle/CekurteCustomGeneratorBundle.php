<?php

namespace Cekurte\Custom\GeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CekurteCustomGeneratorBundle extends Bundle
{
    public function getParent()
    {
        return 'CekurteGeneratorBundle';
    }
}
