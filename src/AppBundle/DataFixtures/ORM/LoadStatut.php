<?php
/**
 * Created by PhpStorm.
 * User: oguim
 * Date: 06/08/2017
 * Time: 12:07
 */

// src/AppBundle/DataFixtures/ORM/LoadStatut.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Statut;

class LoadStatut implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            ['P','Présent(indigène ou indéterminé)'],
            ['B','Occasionnel'],
            ['E','Endémique'],
            ['S','Subendémique'],
            ['C','Cryptogène'],
            ['I','Introduit'],
            ['J','Introduit envahissant'],
            ['M','Introduit non établi (dont domestique)'],
            ['D','Douteux'],
            ['A','Absent'],
            ['W','Disparu'],
            ['E','Eteint'],
            ['Y','Introduit éteint / disparu'],
            ['Z','Endémique éteint'],
            ['Q','Mentionné par erreur']
        );

        foreach ($names as $name) {
            $statut = new Statut();
            $statut ->setCle($name[0]);
            $statut ->setLibelle($name[1]);
            // On la persiste
            $manager->persist($statut);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}