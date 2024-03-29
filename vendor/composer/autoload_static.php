<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit31ee7df4a7bd405be9743cd8297eb5e0
{
    public static $files = array (
        '3f8bdd3b35094c73a26f0106e3c0f8b2' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/SendGrid.php',
        '9dda55337a76a24e949fbcc5d905a2c7' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helpers/mail/Mail.php',
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'SendGrid' => 
            array (
                0 => __DIR__ . '/..' . '/sendgrid/php-http-client/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit31ee7df4a7bd405be9743cd8297eb5e0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit31ee7df4a7bd405be9743cd8297eb5e0::$classMap;

        }, null, ClassLoader::class);
    }
}
