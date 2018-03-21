<?php

namespace meteocontrol\client\vcomapi\endpoints\sub\systems;

use meteocontrol\vcomapi\model\Inverter;
use meteocontrol\client\vcomapi\endpoints\EndpointInterface;
use meteocontrol\client\vcomapi\endpoints\sub\SubEndpoint;

class Inverters extends SubEndpoint {

    /**
     * @param EndpointInterface $parent
     */
    public function __construct(EndpointInterface $parent) {
        $this->uri = '/inverters';
        $this->api = $parent->getApiClient();
        $this->parent = $parent;
    }

    /**
     * @return Inverter[]
     */
    public function get() {
        $invertersJson = $this->api->run($this->getUri());
        $decodedJson = json_decode($invertersJson, true);
        return Inverter::deserializeArray($decodedJson['data']);
    }

    /**
     * @return Bulk
     */
    public function bulk() {
        return new Bulk($this);
    }
}
