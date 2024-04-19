<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE_idU", columns={"idU"})})
 * @ORM\Entity
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="contact", type="integer", nullable=false)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="categorieP", type="string", length=50, nullable=false)
     */
    private $categoriep;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ouverture", type="time", nullable=false)
     */
    private $ouverture;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=false)
     */
    private $logo;


}
