<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class DoctorValue
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class DoctorValue extends Model
{
    /**
     * DoctorCode constructor.
     */
    public function __construct()
    {
        parent::__construct('doctor_values', ['id'], ['doctor_id', 'content']);
    }

    /**
     * @param int $doctorId
     * @param string $columns
     * @return DoctorValue|null
     */
    public function findByDoctorId(int $doctorId, string $columns = '*'): ?DoctorValue
    {
        return $this->find('doctor_id = :id', "id={$doctorId}", $columns)->fetch();
    }
}
