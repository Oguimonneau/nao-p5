<?php
/**
 * Created by PhpStorm.
 * User: oguim
 * Date: 06/08/2017
 * Time: 12:07
 */

// src/AppBundle/DataFixtures/ORM/LoadGeographie.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Geographie;

class LoadGeographie implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            ['FR','Statut biogéographique en France métropolitaine',46.227638,2.213749000000007],
            ['GF','Statut biogéographique en Guyane française','3.933889','-53.125782000000015'],
            ['MAR','Statut biogéographique à la Martinique','14.641528','-61.024174000000016'],
            ['GUA','Statut biogéographique à la Guadeloupe','16.265','-61.55099999999999'],
            ['SM','Statut biogéographique à Saint-Martin','18.0708298','-63.05008090000001'],
            ['SB','Statut biogéographique à Saint-Barthélemy','17.9','-62.83333300000004'],
            ['SPM','Statut biogéographique à Saint-Pierre et Miquelon','46.8852','-56.03159'],
            ['MAY','Statut biogéographique à Mayotte','-12.8275','45.166244000000006'],
            ['EPA','Statut biogéographique aux Îles Éparses','0','0'],
            ['REU','Statut biogéographique à la Réunion','-21.115141','55.536384'],
            ['SA','Statut biogéographique aux îles subantarctiques','0','0'],
            ['TA','Statut biogéographique en Terre Adélie','0','0'],
            ['TAAF','Statut biogéographique aux TAAF, calculé à partir des champs SA et TA','0','0'],
            ['PF','Statut biogéographique en Polynésie française','-17.679742','-149.40684299999998'],
            ['NC','Statut biogéographique en Nouvelle-Calédonie','-20.904305','165.61804200000006'],
            ['WF','Statut biogéographique à Wallis et Futuna','-14.2938','-178.11649999999997'],
            ['CLI','Statut biogéographique à Clipperton','10.2833333','-109.21666670000002']
        );

        foreach ($names as $name) {
            $geographie = new Geographie();
            $geographie->setCle($name[0]);
            $geographie->setLibelle($name[1]);
            $geographie->setLatitude($name[2]);
            $geographie->setLongitude($name[3]);
            // On la persiste
            $manager->persist($geographie);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}