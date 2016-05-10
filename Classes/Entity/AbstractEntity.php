<?php

namespace CedricZiel\Simplebase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Superclass for mapped entities
 *
 * @ORM\MappedSuperclass
 * @package CedricZiel\Simplebase\Entity
 */
abstract class AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $uid;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $pid;

    /**
     * @ORM\Column(name="crdate", type="integer")
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="tstamp", type="integer")
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }
}
