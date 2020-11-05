<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * JSON-PHP | Class User
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
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