<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Sitemap extends BaseConfig
{
    /**
     * Frequência de atualização das páginas
     * 
     * @var string
     */
    public $defaultChangefreq = 'weekly';

    /**
     * Prioridade padrão das páginas (0.0 a 1.0)
     * 
     * @var float
     */
    public $defaultPriority = 0.8;

    /**
     * Prioridade da página inicial
     * 
     * @var float
     */
    public $homePriority = 1.0;

    /**
     * Frequência de atualização da página inicial
     * 
     * @var string
     */
    public $homeChangefreq = 'daily';

    /**
     * Incluir data da última modificação
     * 
     * @var bool
     */
    public $useLastmod = true;

    /**
     * URL base do site (será preenchida automaticamente se null)
     * 
     * @var string|null
     */
    public $baseURL = null;

    /**
     * Caminho para salvar o sitemap (relativo ao diretório public)
     * 
     * @var string
     */
    public $sitemapPath = 'sitemap.xml';

    public function __construct()
    {
        parent::__construct();
        
        if ($this->baseURL === null) {
            $this->baseURL = config('App')->baseURL;
        }
    }
}
