<?php

namespace meteocontrol\vcomapi\model;

use meteocontrol\client\vcomapi\filters\MeasurementsCriteria;

class DevicesMeasurementWithInterval extends DevicesMeasurement {

    /**
     * @param array $data
     * @param null|string $name
     * @return $this
     */
    public static function deserialize(array $data, $name = null) {
        $object = new static();

        foreach ($data as $deviceId => $abbreviationMeasurements) {
            $deviceMeasurements = [];
            foreach ($abbreviationMeasurements as $abbreviation => $value) {
                $deviceMeasurements[$abbreviation] = MeasurementValueWithInterval::deserializeArray($value);
            }
            $object->values[$deviceId] = $deviceMeasurements;
        }
        return $object;
    }
}