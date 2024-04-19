<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avistransport
 *
 * @ORM\Table(name="avistransport", indexes={@ORM\Index(name="avistransport_fk", columns={"idTransport"})})
 * @ORM\Entity
 */
class Avistransport
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAvis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idavis;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avis", type="text", length=65535, nullable=true)
     */
    private $avis;

    /**
     * @var \Transport
     *
     * @ORM\ManyToOne(targetEntity="Transport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTransport", referencedColumnName="idT")
     * })
     */
    private $idtransport;


}
