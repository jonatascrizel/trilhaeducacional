<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['user_name', 'user_email', 'user_password', 'user_created_at', 'ativo','troca_senha','telefone'];

    public function listaUsuarios(){
        $query = $this->db->query('SELECT 
                                        u.id,
                                        u.user_name,
                                        u.user_email,
                                        u.ativo
                                    FROM 
                                        usuarios u
                                    ORDER BY 
                                        u.user_name');
        return $query->getResult();
    }


    /**
     * geraMenu
     * Gera os menus do sistema habilitado para um usuário específico
     *
     * @param  int $id_usuario
     * @return array
     */
    public function geraMenu($id_usuario)
    {
        $query = $this->db->query('SELECT
                                        m.id,
                                        m.nome,
                                        m.icone,
                                        m.controller,
                                        m.title,
                                        m.new_window,
                                        m.subnivel
                                    FROM
                                        menus m LEFT JOIN usuario_x_menu um ON um.id_menu = m.id
                                    WHERE
                                        um.id_usuario = ' . $id_usuario . '
                                    ORDER BY
                                        m.nome');

        return $query->getResult();
    }
}
