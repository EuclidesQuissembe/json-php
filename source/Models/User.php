<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * Class User
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ['id'], ['name', 'email', 'password']);
    }
}