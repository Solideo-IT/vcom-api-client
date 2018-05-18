<?php

namespace meteocontrol\vcomapi\model;

class SystemDetail extends BaseModel {

    /** @var Address */
    public $address;
    /** @var int */
    public $elevation;
    /** @var \DateTime */
    public $commissionDate;
    /** @var Coordinates */
    public $coordinates;
    /** @var string */
    public $name;
    /** @var Timezone */
    public $timezone;
    /** @var string */
    public $currency;

    /**
     * @param array $data
     * @param null|string $name
     * @return $this
     */
    public static function deserialize(array $data, $name = null) {
        $object = new static();

        foreach ($data as $key => $value) {
            if (is_array($value) && $key === "address") {
                $object->address = Address::deserialize($value);
            } elseif (is_array($value) && $key === "coordinates") {
                $object->coordinates = Coordinates::deserialize($value);
            } elseif (is_array($value) && $key === "timezone") {
                $object->timezone = Timezone::deserialize($value);
            } elseif ($key === "commissionDate") {
                $object->commissionDate = self::deserializeCommissionDate($value, $data);
            } elseif (property_exists($object, $key)) {
                $object->{$key} = self::getPhpValue($value);
            }
        }
        return $object;
    }

    /**
     * @param \DateTime $dateTime
     * @param null|string $key
     * @return string
     */
    protected function serializeDateTime(\DateTime $dateTime, $key = null) {
        if ($key === 'commissionDate') {
            return $dateTime->format('Y-m-d');
        }
        return parent::serializeDateTime($dateTime);
    }

    /**
     * @param string $dateString
     * @param array $data
     * @return bool|\DateTime
     */
    private static function deserializeCommissionDate($dateString, array $data) {
        return \DateTime::createFromFormat(
            'Y-m-d H:i:s',
            "{$dateString} 00:00:00",
            isset($data['timezone']['name']) ? new \DateTimeZone($data['timezone']['name']) : null
        );
    }
}
