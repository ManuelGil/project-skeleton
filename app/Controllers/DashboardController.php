<?php

namespace App\Controllers;

use App\Models\UserModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * DashboardController class
 */
class DashboardController
{

    /**
     * This method load the 'home' route. <br/>
     * <b>post: </b>access to GET method.
     */
    public function getIndex()
    {
        if (!$_SESSION['login']) {
            return new RedirectResponse('/', 302);
        }

        $userModel = new UserModel();
        $user = $userModel->findById($_SESSION['id']);

        return new Response(require '../app/views/home.php', 200);
    }
}
