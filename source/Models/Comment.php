<?php


namespace Source\Models;

/**
 * JSON-PHP | Class Comment
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Comment extends \Source\Core\Model
{
    /**
     * Comment constructor.
     */
    public function __construct()
    {
        parent::__construct('comments', ['id'], ['speciality_id', 'name']);
    }
}
