<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SellerController extends AbstractController
{
    /**
     * @Template("seller_dashboard.html.twig")
     */
    public function dashboard(
        ProductRepositoryInterface $productRepo
    ): array {
        return [
            'products' => $productRepo->findBy(['seller' => $this->getUser()])
        ];
    }

    public function createProduct(
        ProductFactoryInterface $productFactory,
        ProductRepositoryInterface $productRepo
    ) {
        /** @var Product $product */
        $product = $productFactory->createNew();

        $user = $this->getUser();
        $dateTime = new \DateTime();
        $product->setName(sprintf(
            'created by %s at %s',
            $user->getUsername(),
            $dateTime->format('c')
        ));
        $product->setCode((string) $dateTime->getTimestamp());
        $product->setSlug((string) $dateTime->getTimestamp());

        $product->setSeller($this->getUser());

        $productRepo->add($product);

        return $this->redirectToRoute('app_seller_dashboard');
    }
}
