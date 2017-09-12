<?php

namespace Controllers;

use Psr\Http\Message\RequestInterface;

class Request implements RequestInterface {
    private $method;
    private $uri;
    private $url;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function getRequestTarget() {
        return $this->uri;
    }

    /**
     * http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     */
    public function withRequestTarget($requestTarget) {
        return $this;
    }

    public function getMethod() {
        return $this->method;
    }

    public function withMethod($method) {
        $request = clone $this;
        $request->setMethod($method);
        return $request;
    }

    protected function setMethod($method) {
        $this->method = $method;
    }

    public function getUri() {
        return $this->url;
    }

    public function withUri(UriInterface $uri, $preserveHost = false) {
        // Need to check host for this and received uri and set host for received if needed

        $this->url = $uri;
    }
}