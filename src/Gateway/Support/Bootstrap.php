<?php

namespace Roamtech\Gateway\Support;

use Composer\Script\Event;

class Bootstrap
{
    public static function run(Event $event)
    {
        $config    = __DIR__ . '/../../../assets/config/roamtechapi.php';
        $configDir = self::getConfigDirectory($event);

        if (! \is_file($configDir . '/roamtechapi.php')) {
            \copy($config, $configDir . '/roamtechapi.php');
        }
    }

    public static function getConfigDirectory(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $configDir = $vendorDir . '/../config';

        if (! \is_dir($configDir)) {
            \mkdir($configDir, 0755, true);
        }

        return $configDir;
    }
}
