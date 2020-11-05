<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class Groups
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Groups extends Model
{
    /**
     * Groups constructor.
     */
    public function __construct()
    {
        parent::__construct('groups', ['id'], ['doctor_id', 'name']);
    }
}
