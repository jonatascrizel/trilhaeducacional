<?php

use App\Models\UserModel;


if (! function_exists('check_menu_access')) {
  function check_menu_access(int $id_menu): void {
    $session = session();
    $userId  = $session->get('user_id');

    $userModel = new UserModel();
    $rtn = $userModel->checkMenu($userId, $id_menu)->getRow();

    if ($rtn && $rtn->cont == 0) {
      header('Location: ' . base_url('/dashboard'));
      exit();
    }
  }

}
