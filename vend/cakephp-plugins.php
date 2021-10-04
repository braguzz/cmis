<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Authorization' => $baseDir . '/vendor/cakephp/authorization/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'BootstrapUI' => $baseDir . '/vendor/friendsofcake/bootstrap-ui/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'Captcha' => $baseDir . '/vendor/dereuromark/cakephp-captcha/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Icings/Menu' => $baseDir . '/vendor/icings/menu/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Muffin/OAuth2' => $baseDir . '/vendor/muffin/oauth2/',
        'ReportSql' => $baseDir . '/plugins/ReportSql/',
        'RtBake' => $baseDir . '/plugins/RtBake/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/',
        'TinyAuth' => $baseDir . '/vendor/dereuromark/cakephp-tinyauth/',
    ],
];
