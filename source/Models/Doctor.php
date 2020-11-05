<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * JSON-PHP | Class Doctor
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Doctor extends Model
{
    /**
     * Doctor constructor.
     */
    public function __construct()
    {
        parent::__construct('doctors', ['id'], ['name']);
    }
}