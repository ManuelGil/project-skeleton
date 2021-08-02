<?php

namespace App\Entities;

/**
 * User class
 */
class User
{

    public $id;
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $status;
    public $created_at;
    public $role_id;

    /**
     * __construct function
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) {
                $this->id = $data['id'];
            }

            $this->username = $data['username'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->first_name = $data['first_name'];
            $this->last_name = $data['last_name'];
            $this->status = $data['status'];
            $this->created_at = $data['created_at'];
            $this->role_id = $data['role_id'];
        }
    }
}
