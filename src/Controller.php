<?php

namespace WebApp;

/**
 * Base controller
 *
 * Class Controller
 * @package WebApp
 */
class Controller
{
    /**
     * @param string $view
     * @param array $data
     */
    protected function render(string $view, $data = [])
    {
        extract($data);

        include "Views/$view.php";
    }

    /**
     * @param string $view
     */
    protected function redirect(string $view)
    {
        header("location: $view");
    }
}