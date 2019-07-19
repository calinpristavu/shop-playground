<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class SellerController
{
    public function index()
    {
        return new Response('<body>seller</body>');
    }
}
