<?php

declare(strict_types=1);

namespace App\Fixture\Factory;

use Faker\Factory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface as CustotmerComponent;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellerUserExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $userFactory;

    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(
        FactoryInterface $userFactory
    ) {
        $this->userFactory = $userFactory;

        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): UserInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var UserInterface $user */
        $user = $this->userFactory->createNew();
        $user->setUsername($options['email']);
        $user->setUsernameCanonical($options['email']);
        $user->setPlainPassword($options['password']);
        $user->setEnabled($options['enabled']);
        $user->addRole('ROLE_SELLER');

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('email', function (Options $options): string {
                return $this->faker->email;
            })
            ->setDefault('first_name', function (Options $options): string {
                return $this->faker->firstName;
            })
            ->setDefault('last_name', function (Options $options): string {
                return $this->faker->lastName;
            })
            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')
            ->setDefault('password', 'password123')
            ->setDefault('gender', CustotmerComponent::UNKNOWN_GENDER)
            ->setAllowedValues(
                'gender',
                [CustotmerComponent::UNKNOWN_GENDER, CustotmerComponent::MALE_GENDER, CustotmerComponent::FEMALE_GENDER]
            )
            ->setDefault('phone_number', function (Options $options): string {
                return $this->faker->phoneNumber;
            })
            ->setDefault('birthday', function (Options $options): \DateTime {
                return $this->faker->dateTimeThisCentury();
            })
            ->setAllowedTypes('birthday', ['null', 'string', \DateTimeInterface::class])
            ->setNormalizer('birthday', function (Options $options, $value) {
                if (is_string($value)) {
                    return \DateTime::createFromFormat('Y-m-d H:i:s', $value);
                }

                return $value;
            })
        ;
    }
}
