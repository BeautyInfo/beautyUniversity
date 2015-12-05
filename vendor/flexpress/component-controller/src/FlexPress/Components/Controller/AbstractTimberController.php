<?php

namespace FlexPress\Components\Controller;

abstract class AbstractTimberController extends AbstractController
{

    /**
     * Renders the given template with a context using timber
     *
     * @param $template
     * @param $context
     * @throws \RuntimeException
     * @author Tim Perry
     */
    protected function render($template, $context)
    {

        if (!class_exists('Timber')) {
            throw new \RuntimeException("Timber is not installed");
        }

        \Timber::render($template, $context);

    }
}
