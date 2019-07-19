<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\User\Model\User;

/**
 * @Entity(repositoryClass="App\Repository\SellerUserRepository")
 * @Table(name="app_seller_user")
 */
class SellerUser extends User
{
    public const DEFAULT_ROLE = 'ROLE_SELLER';
}
