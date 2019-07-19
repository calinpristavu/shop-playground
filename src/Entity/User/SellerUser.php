<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\User\Model\User;

/**
 * @Entity(repositoryClass="App\Repository\SellerUserRepository")
 * @Table(name="app_seller_user")
 */
class SellerUser extends User
{
    /**
     * @var Collection|ProductInterface[]
     */
    private $soldProducts;

    public const DEFAULT_ROLE = 'ROLE_SELLER';

    public function __construct()
    {
        parent::__construct();

        $this->soldProducts = new ArrayCollection();
    }

    public function getSoldProducts(): Collection
    {
        return $this->soldProducts;
    }

    public function addSoldProduct(ProductInterface $product): self
    {
        $this->soldProducts->add($product);

        return $this;
    }

    public function removeSoldProduct(ProductInterface $product): self
    {
        $this->soldProducts->removeElement($product);

        return $this;
    }
}
