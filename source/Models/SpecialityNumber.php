<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class SpecialityNumber
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class SpecialityNumber extends Model
{
    /**
     * SpecialityNumber constructor.
     */
    public function __construct()
    {
        parent::__construct('speciality_numbers', ['id'], ['speciality_id', 'number']);
    }
}
