<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification", indexes={@ORM\Index(name="notification_ibfk_1", columns={"IdR"})})
 * @ORM\Entity
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="idn", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notificationPreference", type="string", length=255, nullable=true)
     */
    private $notificationpreference;

    /**
     * @var string|null
     *
     * @ORM\Column(name="invitationStatus", type="string", length=255, nullable=true)
     */
    private $invitationstatus;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdR", referencedColumnName="id")
     * })
     */
    private $idr;


}
