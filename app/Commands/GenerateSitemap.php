<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class GenerateSitemap extends BaseCommand
{
    protected $group = 'Sitemap';
    protected $name = 'sitemap:generate';
    protected $description = 'Gera o arquivo sitemap.xml';

    public function run(array $params)
    {
        $sitemapController = new \App\Controllers\Sitemap();
        $result = $sitemapController->generate();
        
        CLI::write($result, 'green');
    }
}
