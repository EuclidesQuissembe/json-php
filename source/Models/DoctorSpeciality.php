<?php


namespace Source\Models;

/**
 * JSON-PHP | Class DoctorSpeciality
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class DoctorSpeciality extends \Source\Core\Model
{
    /**
     * DoctorRoof constructor.
     */
    public function __construct()
    {
        parent::__construct('doctors_speciality', ['id'], ['speciality_id', 'doctor_id']);
    }
}
