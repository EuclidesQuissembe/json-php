<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class Speciality
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Models
 */
class Speciality extends Model
{
    /**
     * Speciality constructor.
     */
    public function __construct()
    {
        parent::__construct('specialities', ['id'], ['slug', 'name']);
    }

    /**
     * @param string $slug
     * @param string $columns
     * @return Speciality|null
     */
    public function findBySlug(string $slug, string $columns = '*'): ?Speciality
    {
        return $this->find('slug = :slug', "slug={$slug}", $columns)->fetch();
    }
}
