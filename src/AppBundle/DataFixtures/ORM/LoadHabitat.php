<?php
/**
 * Created by PhpStorm.
 * User: oguim
 * Date: 06/08/2017
 * Time: 12:07
 */

// src/AppBundle/DataFixtures/ORM/LoadHabitat.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Habitat;

class LoadHabitat implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $names = array(
            'Marin',
            'Eau douce',
            'Terrestre',
            'Marin & Eau douce',
            'Marin & Terrestre',
            'Eau saumâtre',
            'Continental (terrestre et/ou eau douce)',
            'Continental (terrestre et eau douce)'
        );

        foreach ($names as $name) {
            // On crée la catégorie
            $habitat = new Habitat();
            $habitat ->setDescription($name);

            // On la persiste
            $manager->persist($habitat);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}