<?php


namespace Source\Models;

/**
 * JSON-PHP | Class DoctorRoof
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class DoctorRoof extends \Source\Core\Model
{
    /**
     * DoctorRoof constructor.
     */
    public function __construct()
    {
        parent::__construct('doctors_roofing', ['id'], ['speciality_id', 'doctor_id']);
    }
}
