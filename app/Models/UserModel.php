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

    public function getMenus()
    {
        $query = $this->db->query('SELECT * FROM menus ORDER BY nome');
        return $query->getResult();
    }

    public function salvaMenusUsuario($arr_menus, $id_user)
    {
        //apaga as permissões já existentes
        $this->db->query('DELETE FROM usuario_x_menu WHERE id_user = ' . $id_user);

        $sql = 'INSERT INTO usuario_x_menu (id_menu, id_user) VALUES ';
        foreach ($arr_menus as $v) {
            $sql .= ' (' . $v . ', ' . $id_user . '),';
        }
        $sql = substr($sql, 0, -1);
        $this->db->query($sql);
    }
}
