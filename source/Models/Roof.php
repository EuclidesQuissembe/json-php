<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * JSON-PHP | Class Roof
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package source\Models
 */
class Roof extends Model
{
    /**
     * Roof constructor.
     */
    public function __construct()
    {
        parent::__construct('roofing', ['id'], ['slug', 'speciality_id', 'name']);
    }

    /**
     * @param string $slug
     * @param string $columns
     * @return Roof|null
     */
    public function findBySlug(string $slug, string $columns = '*'): ?Roof
    {
        return $this->find('slug = :slug', "slug={$slug}", $columns)->fetch();
    }
}
