<?php


namespace source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class Roof
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package source\Models
 */
class Roof extends Model
{
    /**
     * Roof constructor.
     */
    public function __construct()
    {
        parent::__construct('roofing', ['id'], ['speciality_id', 'name']);
    }
}
