<?php

namespace Controllers;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface {

    private $scheme;
    private $host;

    public function getScheme() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * [user-info@]host[:port]
     */
    public function getAuthority() {
        $port = $this->getPort();
        $host = $this->getHost();
        $user = $_SERVER['REMOTE_USER'];

        $authority = "";

        if (!empty($user)) {
            $authority .= $user . '@'; 
        }

        $authority .= $host;

        if (!empty($port) && $port != 80) {
            $authority .= ":" . $port;
        }

        return $authority;
    }

    public function getUserInfo(){

    }

    public function getHost(){
        return $_SERVER['SERVER_NAME'];
    }

    public function getPort(){
        return (int) $_SERVER['SERVER_PORT'];
    }

    public function getPath(){
        return $_SERVER['REQUEST_URI'];
    }

    public function getQuery(){
        return $_SERVER['QUERY_STRING'];
    }

    public function getFragment(){}

    public function withScheme($scheme){
        $this->scheme = $scheme;
        return $this;
    }

    public function withUserInfo($user, $password = null){}

    public function withHost($host){
        $this->host = $host;
        return $this;
    }

    public function withPort($port){}

    public function withPath($path){}

    public function withQuery($query){}

    public function withFragment($fragment){}

    public function __toString(){}
}