<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/09/16
 * Time: 09:10
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="prices",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="prices_type_place_unique", columns={"type", "place_id"})}
 * )
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="float")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="prices")
     * @var Place
     */
    protected $place;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return Place
     */
    public function getPlace()
    {
        return $this->place;
    }


    public function setPlace($place)
    {
        $this->place = $place;
        return $this;
    }


}