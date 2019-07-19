<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\User\SellerUser;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct
{
    /**
     * @var SellerUser
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\SellerUser", inversedBy="soldProducts")
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="id")
     */
    private $seller;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    public function getSeller(): SellerUser
    {
        return $this->seller;
    }

    public function setSeller(SellerUser $seller): self
    {
        $this->seller = $seller;

        return $this;
    }
}
