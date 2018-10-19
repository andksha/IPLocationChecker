<?php

class IPChecker
{

    private $ips;

    public function __construct($pdo)
    {
        $this->setIPs($pdo);
    }

    public function setIPs($pdo)
    {
        $this->ips = $pdo->query('SELECT ip, country FROM tb_ip_addresses WHERE 1');
    }

    public function getIPs()
    {
        return $this->ips;
    }

    public function checkIPLocation($pdo)
    {
        $responses = [];

        foreach ($this->ips as $ip) {
            array_push($responses, json_decode(file_get_contents(
                'http://api.ipapi.com/' . $ip['ip'] . '?access_key=MY_ACCESS_KEY'
            )));
        }

        $sql  = "UPDATE tb_ip_addresses SET country=? WHERE ip=?";
        $stmt = $pdo->prepare($sql);

        foreach ($responses as $key => $response ) {
            if ($response->success == true) {
                $updateResult = $stmt->execute([$response->country_name, $response->ip]);
            } else {
                $updateResult = false;
            }
        }

        return $updateResult;
    }

}