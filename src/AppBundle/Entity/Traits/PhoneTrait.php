<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/** adds phone fields to entity **/
trait PhoneTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="countryCode", type="integer")
     */
    private $countryCode = 381;

    /**
     * @var int
     *
     * @ORM\Column(name="areaCode", type="integer")
     */
    private $areaCode;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer")
     */
    private $phone;


    /**
     * Get the value of Country Code
     *
     * @return int
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set the value of Country Code
     *
     * @param int $countryCode
     *
     * @return self
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get the value of Area Code
     *
     * @return int
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set the value of Area Code
     *
     * @param int $areaCode
     *
     * @return self
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    /**
     * Get the value of Phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of Phone
     *
     * @param int $phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Returns __toString representation of phone
     *
     * @return string
     */
    public function getPhoneAsString()
    {
        return sprintf('+%d (%d) %d', $this->getCountryCode(),
                                      $this->getAreaCode(),
                                      $this->getPhone());
    }

}
