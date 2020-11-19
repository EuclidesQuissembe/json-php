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
        parent::__construct('subgroups', ['id'], ['doctor_id', 'name']);
    }

    /**
     * @param int $doctorId
     * @param string $columns
     * @return SubGroup|null
     */
    public function findByDoctorId(int $doctorId, string $columns = '*'): ?SubGroup
    {
        return $this->find('doctor_id = :id', "id={$doctorId}", $columns)->fetch();
    }
}
