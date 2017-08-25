<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Volume
 *
 * @ORM\Table(name="volume")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VolumeRepository")
 */
class Volume
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Manga",inversedBy="volumes")
     */
    private $manga;

    /**
     * @var int
     *
     * @ORM\Column(name="volumeNumber", type="integer")
     *
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Give number add least greater than {{ limit }}",
     * )
     */
    private $volumeNumber;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="datetime")
     */
    private $releaseDate;

    public function __toString() {
        return (string) $this->volumeNumber;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set volumeNumber
     *
     * @param integer $volumeNumber
     *
     * @return Volume
     */
    public function setVolumeNumber($volumeNumber)
    {
        $this->volumeNumber = $volumeNumber;

        return $this;
    }

    /**
     * Get volumeNumber
     *
     * @return int
     */
    public function getVolumeNumber()
    {
        return $this->volumeNumber;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Volume
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Volume
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $manga
     */
    public function setManga($manga)
    {
        $this->manga = $manga;
    }
}

