<?php
namespace Vendor\Esmefis;

class LocalCookie
{
    public static function setTemporalCookie($clientId)
    {
        if (isset($_COOKIE['clientId'])) {
            unset($_COOKIE['clientId']);
            setcookie('clientId', $clientId, time() + 3600, '/');
        } else {
            setcookie('clientId', $clientId, time() + 3600, '/');
        }
    }
}