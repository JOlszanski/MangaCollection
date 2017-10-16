<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Volume", inversedBy="users",cascade={"persist"}, orphanRemoval=true)
     */
    private $volumes;

    public function __construct()
    {
        parent::__construct();
        $this->volumes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * @param mixed $volumes
     */
    public function setVolumes($volumes): void
    {
        $this->volumes = $volumes;
    }

    public function addVolume(Volume $volume):void
    {
        $volume->addUser($this);
        $this->volumes[] = $volume;
    }

    public function haveVolume(Volume $volume)
    {
        foreach ($this->volumes as $v){
            if ($v == $volume) return true;
        }
        return false;
    }

    public function popVolume(Volume $volume)
    {

        if(!$this->volumes->contains($volume))return;
        $newVolumes = new ArrayCollection();
        foreach ($this->volumes as $DbVolume)
        {
            if ($DbVolume != $volume) $newVolumes[] = $DbVolume;
        }
        $this->volumes = $newVolumes;
        #$this->volumes->removeElement($volume);
        $volume->popUser($this);
    }
}