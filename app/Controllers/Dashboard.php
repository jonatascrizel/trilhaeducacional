<?php

namespace App\Controllers;
use App\Models\UserModel;

require('../vendor/autoload.php');


class dashboard extends BaseController
{
    public function __construct() {
        //parent::__construct();
        $this->caminhoArquivo = WRITEPATH . 'uploads/dados_dashboard.json';

        $this->daysofweek = [
            1 => 'Dom',
            2 => 'Seg',
            3 => 'Ter',
            4 => 'Qua',
            5 => 'Qui',
            6 => 'Sex',
            7 => 'Sab',
        ];

        $this->UserModel = new UserModel();
    }

    public function index() {
        if (file_exists($this->caminhoArquivo)) {
            $conteudoJson = file_get_contents($this->caminhoArquivo);
            $data  = json_decode($conteudoJson, true);
        }
        
        //$data = [];
        return view('dashboard', $data);
    }

    public function trocaSenha() {
        $data = [];
        return view('troca_senha', $data);
    }

    public function trocaSenhaDo() {
        if (!is_numeric($this->session->get('user_id'))) {
            return redirect()->to(base_url('/logout'));
        }

        log_message('info', 'O usuário '.$this->session->get('user_name').' alterou sua senha');

        $data = [
            'user_password' => password_hash($this->request->getVar('pws_nova'), PASSWORD_DEFAULT),
            'troca_senha' => 0,
        ];
        $save = $this->UserModel->update($this->session->get('user_id'), $data);

        return redirect()->to(base_url('/dashboard'));
    }

    public function geraStats(){
        $dados = [];
        $dados['daysofweek'] = $this->daysofweek;

        $query = $this->db->query('SELECT 
                                        DAYOFWEEK(dataHora) AS dia_da_semana,
                                        COUNT(*) AS total_logins
                                    FROM 
                                        cursante_log
                                    GROUP BY 
                                        DAYNAME(dataHora), 
                                        DAYOFWEEK(dataHora)
                                    ORDER BY 
                                        DAYOFWEEK(dataHora)')
                            ->getResult();
        foreach($query as $q){
            $dados['dayofweek'][$q->dia_da_semana] = $q->total_logins;
        }
        for($i=1; $i<=7; $i++){
            if(!array_key_exists($i, $dados['dayofweek'])) {
                $dados['dayofweek'][$i] = 0;
            }
        }

        $query = $this->db->query('SELECT 
                                        COUNT(CASE WHEN DATEDIFF(ultimo_acesso, aceito_em) >= 1 THEN 1 END) AS acessos_D1,
                                        COUNT(CASE WHEN DATEDIFF(ultimo_acesso, aceito_em) >= 5 THEN 1 END) AS acessos_D5,
                                        COUNT(CASE WHEN DATEDIFF(ultimo_acesso, aceito_em) >= 10 THEN 1 END) AS acessos_D10
                                    FROM 
                                        cursante_cursos
                                    WHERE 
                                        ultimo_acesso IS NOT NULL')
                            ->getResult();
        foreach($query as $q){
            $dados['sobrevivencia']['acessos_D1'] = $q->acessos_D1;
            $dados['sobrevivencia']['acessos_D5'] = $q->acessos_D5;
            $dados['sobrevivencia']['acessos_D10'] = $q->acessos_D10;
        }


        $query = $this->db->query('SELECT 
                                        DAYOFWEEK(feita_em) AS dia_da_semana,
                                        HOUR(feita_em) AS hora_do_dia,
                                        COUNT(*) AS total_respostas
                                    FROM 
                                        cursante_licoes
                                    GROUP BY 
                                        DAYNAME(feita_em),
                                        DAYOFWEEK(feita_em),
                                        HOUR(feita_em)
                                    ORDER BY 
                                        DAYOFWEEK(feita_em) ASC, 
                                        hora_do_dia ASC')
                            ->getResult();
        foreach($query as $q){
            $dados['volume_respostas'][$q->dia_da_semana][$q->hora_do_dia] = $q->total_respostas;
        }
        

        $dados['taxa_conclusao'] = [
            'naoiniciou' => 0,
            'iniciou' => 0,
            'metade' => 0,
            'concluido' => 0,
        ];
        $query = $this->db->query('SELECT 
                                        progresso.id_cursos AS curso_id,    
                                        COUNT(CASE WHEN progresso.licoes_feitas = 0 THEN 1 END) AS naoiniciou,
                                        -- Iniciou: fez pelo menos 1 lição
                                        COUNT(CASE WHEN progresso.licoes_feitas >= 1 THEN 1 END) AS iniciou,
                                        -- Metade: fez 50% ou mais das lições (e ainda não terminou)
                                        COUNT(CASE WHEN progresso.licoes_feitas >= (progresso.total_licoes / 2) AND progresso.licoes_feitas < progresso.total_licoes THEN 1 END) AS metade,
                                        -- Concluiu: fez exatamente a mesma quantidade de lições que o curso possui
                                        COUNT(CASE WHEN progresso.licoes_feitas = progresso.total_licoes AND progresso.total_licoes > 0 THEN 1 END) AS concluido    
                                    FROM (
                                        SELECT 
                                            cc.id_cursos,
                                            cc.id_cursante,
                                            COUNT(DISTINCT c_lic.id) AS total_licoes,
                                            COUNT(DISTINCT cli.id) AS licoes_feitas
                                        FROM 
                                            cursante_cursos cc
                                        LEFT JOIN
                                        cursos_unidades cu ON cu.id_curso = cc.id_cursos
                                        LEFT JOIN 
                                            cursos_licoes c_lic ON c_lic.id_cursos_unidades = cu.id
                                        LEFT JOIN 
                                            cursante_licoes cli ON cli.id_cursante = cc.id_cursante AND cli.id_licao = c_lic.id
                                        GROUP BY 
                                            cc.id_cursos, 
                                            cc.id_cursante
                                    ) AS progresso
                                    GROUP BY 
                                        progresso.id_cursos')
                            ->getResult();
        foreach($query as $q){
            $dados['taxa_conclusao']['naoiniciou'] += $q->naoiniciou;
            $dados['taxa_conclusao']['iniciou'] += $q->iniciou;
            $dados['taxa_conclusao']['metade'] += $q->metade;
            $dados['taxa_conclusao']['concluido'] += $q->concluido;
        }
        

        $query = $this->db->query('SELECT
                                        cl.titulo,
                                        CASE
                                            WHEN cl.id_cursos_licoes_tipo = 1 THEN (SELECT
                                                                    COUNT(cul.id)
                                                                FROM
                                                                    cursante_licoes cul,
                                                                    cursos_licoes_tipo_1 clt
                                                                WHERE
                                                                    clt.id_cursos_licoes = cul.id_licao
                                                                    AND cul.resposta != clt.resposta_certa
                                                                    AND cul.id_licao = cl.id)
                                            WHEN cl.id_cursos_licoes_tipo = 7 THEN (SELECT
                                                                    COUNT(cul.id)
                                                                FROM
                                                                    cursante_licoes cul,
                                                                    cursos_licoes_tipo_7 clt
                                                                WHERE
                                                                    clt.id_cursos_licoes = cul.id_licao
                                                                    AND cul.resposta != "1,2,3,4,5"
                                                                    AND cul.id_licao = cl.id)
                                            WHEN cl.id_cursos_licoes_tipo = 8 THEN (SELECT
                                                                    COUNT(cul.id)
                                                                FROM
                                                                    cursante_licoes cul,
                                                                    cursos_licoes_tipo_8 clt
                                                                WHERE
                                                                    clt.id_cursos_licoes = cul.id_licao
                                                                    AND cul.resposta != clt.vouf
                                                                    AND cul.id_licao = cl.id)
                                        END AS erros
                                    FROM
                                        cursos_licoes cl
                                    WHERE
                                        cl.id_cursos_licoes_tipo IN (1,7,8)

                                    HAVING 
                                        erros > 0
                                    ORDER BY 
                                        erros DESC
                                    LIMIT 5
                                    ')
                            ->getResult();
        foreach($query as $q){
            $dados['mais_erradas'][$q->titulo] = $q->erros;
        }
        



        $jsonString = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


        if (write_file($this->caminhoArquivo, $jsonString)) {
            echo "Arquivo JSON gravado com sucesso!";
        } else {
            echo "Erro ao tentar gravar o arquivo.";
        }

    }


}
