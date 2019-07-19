<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;

final class SellerUserLogoutHandler extends DefaultLogoutSuccessHandler
{
}
