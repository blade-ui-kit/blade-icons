<?php

use Zondicons\ZondiconFactory;
use Illuminate\Support\HtmlString;

if (! function_exists('zondicons')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function zondicons()
    {
        return new HtmlString(
            sprintf('<div style="display: none;">%s</div>', file_get_contents(__DIR__ . '/../resources/sprite.svg'))
        );
    }

    function zondicon($icon, $class = '')
    {
        return app(ZondiconFactory::class)->icon($icon, $class);
    }
}
