<?php
// Non Logged Users
$app->group('', function () use ($app, $container, $settings) {
    // Home Page
    $this->map(['GET'], '/', 'App:home')
        ->setName('home');
    // Privacy Policy
    $this->map(['GET'], '/privacy', 'App:privacy')
        ->setName('privacy');
    // Contact
    $this->map(['GET', 'POST'], '/contact', 'App:contact')
        ->setName('contact');
    // Terms and Conditions
    $this->map(['GET'], '/terms', 'App:terms')
        ->setName('terms');
    // CSRF
    $this->map(['GET'], '/csrf', 'App:csrf')
        ->setName('csrf');
    // Cron Jobs
    $this->map(['GET'], '/cron', 'Cron:run')
        ->setName('cron');

    $this->map(['GET'], '/test', 'App:test')
        ->setName('test');
    // Oauth
    $this->map(['GET'], '/oauth/{slug}', 'Oauth2:oauth2')
        ->setName('oauth');
})
->add($container->get('csrf'))
->add(new Dappur\Middleware\Maintenance($container))
->add(new Dappur\Middleware\PageConfig($container))
->add(new Dappur\Middleware\Seo($container))
->add(new Dappur\Middleware\ProfileCheck($container))
->add(new Dappur\Middleware\TwoFactorAuth($container))
->add(new Dappur\Middleware\RouteName($container));

// Maintenance Mode Bypasses All Middleware
$app->map(['GET'], '/maintenance', 'App:maintenance')
        ->setName('maintenance-mode')
        ->add(new Dappur\Middleware\PageConfig($container))
        ->add(new Dappur\Middleware\Seo($container))
        ->add(new Dappur\Middleware\RouteName($container));

// Assets Bypass All Middleware
$app->map(['GET'], '/asset', 'App:asset')
        ->setName('asset');

//Deployment
$app->map(['GET', 'POST'], '/' . $settings['deployment']['deploy_url'], 'Deploy:deploy')
    ->setName('deploy')
    ->add(new Dappur\Middleware\Deploy($container));
