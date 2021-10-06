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
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'ReportSql' => $baseDir . '/plugins/ReportSql/',
        'RtBake' => $baseDir . '/plugins/RtBake/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/',
    ],
];
