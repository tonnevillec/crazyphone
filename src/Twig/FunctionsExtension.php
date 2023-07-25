<?php

namespace App\Twig;

use App\Entity\ContactInformations;
use App\Entity\SocialNetworks;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FunctionsExtension extends AbstractExtension
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    )
    {}

    public function getFunctions(): array
    {
        $default = ['is_safe' => ['html']];

        return [
            new TwigFunction('contactInformation', [$this, 'getContactInformation'], $default),
            new TwigFunction('tSocials', [$this, 'getSocialNetworks'], $default),
        ];
    }

    public function getContactInformation(string $code): string
    {
        $ci = $this->em->getRepository(ContactInformations::class)->findOneBy(['code' => $code]);
        return $ci ? $ci->getValue() : '';
    }

    public function getSocialNetworks(): array
    {
        return $this->em->getRepository(SocialNetworks::class)->findAll();
    }
}