<?php

namespace meteocontrol\client\vcomapi\endpoints\sub\tickets;

use meteocontrol\client\vcomapi\endpoints\EndpointInterface;
use meteocontrol\client\vcomapi\endpoints\sub\SubEndpoint;

class CommentId extends SubEndpoint {

    /**
     * @param EndpointInterface $parent
     * @param int $id
     */
    public function __construct(EndpointInterface $parent, int $id) {
        $this->uri = '/' . $id;
        $this->parent = $parent;
        $this->api = $parent->getApiClient();
    }
}
