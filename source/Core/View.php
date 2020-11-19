<?php

namespace Source\Core;

use League\Plates\Engine;

/**
 * JSON-PHP | Class View
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Core
 */
class View
{
    /** @var Engine */
    private $engine;

    /**
     * View constructor.
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    /**
     * @param string $name
     * @param string $path
     * @return View
     */
    public function path(string $name, string $path): View
    {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * @param array $data
     * @param array|string|null $templates
     * @return Engine
     */
    public function addData(array $data, $templates = null): Engine
    {
        return $this->engine->addData($data, $templates);
    }

    /**
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        return $this->engine->render($templateName, $data);
    }

    /**
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine;
    }
}