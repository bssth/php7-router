<?php

namespace Mike4ip\Router;

/**
 * Class Result
 * @package Mike4ip\Router
 */
class Result
{
    /**
     * @var string
     */
    public $route;

    /**
     * @var string
     */
    public $controller_dir;

    /**
     * Get controller script location
     * @return string
     * @throws NotFoundException
     */
    public function getController(): string
    {
        $filename = $this->controller_dir . '/' . $this->route . '.php';

        if(!file_exists($filename) || !is_readable($filename))
            throw new NotFoundException('Cannot read ' . $filename);

        return $this->controller_dir . '/' . $this->route . '.php';
    }
}