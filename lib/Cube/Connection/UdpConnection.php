<?php
namespace Cube\Connection;
class UdpConnection extends Connection {
    private $udp_host;
    private $udp_port;
    private $sock;

    public function init(array $conf)
    {
        $this->sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $this->udp_host = $conf['udp']['host'];
        $this->udp_port = $conf['udp']['port'];
    }


    public function eventPut($args)
    {
        $args = \Cube\Command::prepPayload($args);
        $json = json_encode($args);
        $res = socket_sendto($this->getSock(), $json, strlen($json), 0, $this->udp_host, $this->udp_port);
        return $res;
    }

    /**
     * @return mixed
     */
    public function getSock()
    {
        return $this->sock;
    }

}
