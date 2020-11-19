<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class Groups
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Group extends Model
{
    /**
     * Groups constructor.
     */
    public function __construct()
    {
        parent::__construct('groups', ['id'], ['doctor_id', 'name']);
    }

    /**
     * @param int $doctorId
     * @param string $columns
     * @return Group|null
     */
    public function findByDoctorId(int $doctorId, string $columns = '*'): ?Group
    {
        return $this->find('doctor_id = :id', "id={$doctorId}", $columns)->fetch();
    }
}
