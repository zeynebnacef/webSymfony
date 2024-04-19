<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transport
 *
 * @ORM\Table(name="transport")
 * @ORM\Entity
 */
class Transport
{
    /**
     * @var int
     *
     * @ORM\Column(name="idT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idt;

    /**
     * @var string
     *
     * @ORM\Column(name="typeT", type="string", length=50, nullable=false)
     */
    private $typet;

    /**
     * @var string
     *
     * @ORM\Column(name="station_depart", type="string", length=255, nullable=false)
     */
    private $stationDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="station_arrive", type="string", length=255, nullable=false)
     */
    private $stationArrive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps_depart", type="time", nullable=false)
     */
    private $tempsDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps_arrive", type="time", nullable=false)
     */
    private $tempsArrive;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idAvis", type="integer", nullable=true)
     */
    private $idavis;


}
