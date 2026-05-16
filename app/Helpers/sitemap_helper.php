<?php

if (!function_exists('generate_sitemap')) {
    /**
     * Gera o sitemap.xml automaticamente
     * 
     * @return void
     */
    function generate_sitemap()
    {
        $homeController = new \App\Controllers\Home();
        $sitemapController = new \App\Controllers\Sitemap();
        
        // Gera o sitemap
        $sitemapController->generate();
    }
}

// Registra um hook para ser executado após a atualização do HomeController
if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
    \CodeIgniter\Events\Events::on('post_controller_constructor', function() {
        $controller = service('router')->controllerName();
        if ($controller === 'App\Controllers\Home') {
            generate_sitemap();
        }
    });
}
