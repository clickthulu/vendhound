<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Settings;
use App\Entity\SettingsCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingsService
{
    private SettingsCollection $settingsCollection;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->settingsCollection = new SettingsCollection();

        $databaseSettings = $entityManager->getRepository(Settings::class)->findAll();
        foreach ($databaseSettings as $setting) {
            $this->settingsCollection->addItem($setting);
        }

    }

    public function get(string $key)
    {
        return $this->settingsCollection->get($key);
    }

    public function set(Settings $item): self
    {
        $this->settingsCollection->addItem($item);
        return $this;
    }
}