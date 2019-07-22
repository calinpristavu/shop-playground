<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SellerController extends AbstractController
{
    /**
     * @Template("seller_dashboard.html.twig")
     */
    public function dashboard(
        Request $request,
        ProductRepositoryInterface $productRepo,
        FormFactoryInterface $formFactory,
        ProductFactoryInterface $productFactory
    ) {
        /** @var Product $product */
        $product = $productFactory->createNew();

        $form = $formFactory->create(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepo->add($product);

            return $this->redirectToRoute('app_seller_dashboard');
        }

        return [
            'form' => $form->createView(),
            'products' => $productRepo->findBy(['seller' => $this->getUser()])
        ];
    }
}
