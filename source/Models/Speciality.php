<?php


namespace Source\Models;

/**
 * JSON-PHP | Class Speciality
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Speciality extends \Source\Core\Model
{
    /**
     * Speciality constructor.
     */
    public function __construct()
    {
        parent::__construct('specialities', ['id'], ['name']);
    }
}
