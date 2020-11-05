<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * JSON-PHP | Class Commentary
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Commentary extends Model
{
    /**
     * Commentary constructor.
     */
    public function __construct()
    {
        parent::__construct('commentaries', ['id'], ['doctor_id', 'content']);
    }
}