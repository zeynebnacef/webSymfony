<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponser
 *
 * @ORM\Table(name="reponser", indexes={@ORM\Index(name="idR", columns={"idR"})})
 * @ORM\Entity
 */
class Reponser
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrr;

    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="textR", type="text", length=65535, nullable=false)
     */
    private $textr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_repR", type="datetime", nullable=false)
     */
    private $dateRepr;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idR", referencedColumnName="idR")
     * })
     */
    private $idr;


}
