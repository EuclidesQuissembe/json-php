<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class SubGroup
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class SubGroup extends Model
{
    /**
     * SubGroup constructor.
     */
    public function __construct()
    {
        parent::__construct('sub-groups', ['id'], ['doctor_id', 'name']);
    }
}
