<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var int
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temp", type="datetime", nullable=false)
     */
    private $temp;

    /**
     * @var string
     *
     * @ORM\Column(name="titreR", type="string", length=255, nullable=false)
     */
    private $titrer;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="typeR", type="string", length=255, nullable=false)
     */
    private $typer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apropo", type="string", length=255, nullable=true)
     */
    private $apropo;


}
