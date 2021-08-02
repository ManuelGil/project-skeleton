<?php

namespace App\Models;

use App\Entities\User;
use App\Libraries\Database;

/**
 * UserModel class
 */
class UserModel
{

    private $table = 'users';

    /**
     * findById function
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id)
    {
        $conn = Database::getInstance();

        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();

            return $user;
        } catch (\PDOException $e) {
            die("DataBase Error: The user could not be found.<br>{$e->getMessage()}");
        } catch (\Throwable $e) {
            die("General Error: The user could not be found.<br>{$e->getMessage()}");
        } finally {
            // Destroy the database connection
            $conn = null;
        }
    }

    /**
     * findByUsername function
     *
     * @param string $username
     * @return User
     */
    public function findByUsername(string $username)
    {
        $conn = Database::getInstance();

        try {
            $sql = "SELECT * FROM {$this->table} WHERE username = :username;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();

            return $user;
        } catch (\PDOException $e) {
            die("DataBase Error: The user could not be found.<br>{$e->getMessage()}");
        } catch (\Throwable $e) {
            die("General Error: The user could not be found.<br>{$e->getMessage()}");
        } finally {
            // Destroy the database connection
            $conn = null;
        }
    }

    /**
     * findByEmail function
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email)
    {
        $conn = Database::getInstance();

        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();

            return $user;
        } catch (\PDOException $e) {
            die("DataBase Error: The user could not be found.<br>{$e->getMessage()}");
        } catch (\Throwable $e) {
            die("General Error: The user could not be found.<br>{$e->getMessage()}");
        } finally {
            // Destroy the database connection
            $conn = null;
        }
    }

    /**
     * findAll function
     *
     * @return array
     */
    public function findAll()
    {
        $conn = Database::getInstance();

        try {
            $sql = "SELECT * FROM {$this->table};";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
            $users = $stmt->fetchAll();

            return $users;
        } catch (\PDOException $e) {
            die("DataBase Error: No results were obtained.<br>{$e->getMessage()}");
        } catch (\Throwable $e) {
            die("General Error: No results were obtained.<br>{$e->getMessage()}");
        } finally {
            // Destroy the database connection
            $conn = null;
        }
    }

    /**
     * update function
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        $conn = Database::getInstance();

        try {
            $sql = "UPDATE {$this->table}
                    SET
                        username = :username,
                        email = :email,
                        password = :password,
                        first_name = :first_name,
                        last_name = :last_name,
                        status = :status,
                        created_at = :created_at,
                        role_id = :role_id
                    WHERE id = :id;";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':id', $user->id);
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':first_name', $user->first_name);
            $stmt->bindParam(':last_name', $user->last_name);
            $stmt->bindParam(':status', $user->status);
            $stmt->bindParam(':created_at', $user->created_at);
            $stmt->bindParam(':role_id', $user->role_id);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            die("DataBase Error: The user could not be updated.<br>{$e->getMessage()}");
        } catch (\Throwable $e) {
            die("General Error: The user could not be updated.<br>{$e->getMessage()}");
        } finally {
            // Destroy the database connection
            $conn = null;
        }
    }
}
