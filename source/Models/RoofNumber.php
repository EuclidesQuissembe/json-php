<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * JSON-PHP | Class RoofNumber
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class RoofNumber extends Model
{
    /**
     * RoofNumber constructor.
     */
    public function __construct()
    {
        parent::__construct('roofing_numbers', ['id'], ['roof_id', 'number']);
    }
}