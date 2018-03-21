<?php

namespace meteocontrol\client\vcomapi\endpoints\sub\tickets;

use meteocontrol\vcomapi\model\TicketHistory;
use meteocontrol\client\vcomapi\endpoints\EndpointInterface;
use meteocontrol\client\vcomapi\endpoints\sub\SubEndpoint;

class Histories extends SubEndpoint {

    /**
     * @param EndpointInterface $parent
     */
    public function __construct(EndpointInterface $parent) {
        $this->uri = '/histories';
        $this->api = $parent->getApiClient();
        $this->parent = $parent;
    }

    /**
     * @return TicketHistory[]
     */
    public function get() {
        $historiesJson = $this->api->run($this->getUri());
        $decodedJson = json_decode($historiesJson, true);
        return TicketHistory::deserializeArray($decodedJson['data']);
    }
}
