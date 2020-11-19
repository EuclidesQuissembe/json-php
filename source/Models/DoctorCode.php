<?php


namespace Source\Models;

/**
 * JSON-PHP | Class DoctorCode
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class DoctorCode extends \Source\Core\Model
{
    /**
     * DoctorCode constructor.
     */
    public function __construct()
    {
        parent::__construct('doctors_code', ['id'], ['doctor_id', 'code']);
    }

    /**
     * @param int $doctorId
     * @param string $columns
     * @return DoctorCode|null
     */
    public function findByDoctorId(int $doctorId, string $columns = '*'): ?DoctorCode
    {
        return $this->find('doctor_id = :id', "id={$doctorId}", $columns)->fetch();
    }
}
