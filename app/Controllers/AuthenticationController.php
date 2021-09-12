<?php

namespace App\Controllers;

use App\Models\UserModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthenticationController class
 */
class AuthenticationController
{

    /**
     * This method load the 'login' route. <br/>
     * <b>post: </b>access to GET method.
     */
    public function getLogin()
    {
        return new Response(require '../app/views/index.php', 200);
    }

    /**
     * This method load the 'login' route. <br/>
     * <b>post: </b>access to POST method.
     */
    public function postLogin(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $userModel = new UserModel();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user->id;

            return new RedirectResponse('/home', 302);
        } else {
            $_SESSION['message'] = "Bad credentials";

            return new RedirectResponse('/', 302);
        }
    }

    /**
     * This method load the 'logout' route. <br/>
     * <b>post: </b>access to GET method.
     */
    public function getLogout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['id']);
        session_destroy();

        return new RedirectResponse('/', 302);
    }
}
