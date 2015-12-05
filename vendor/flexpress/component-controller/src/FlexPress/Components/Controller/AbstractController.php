<?php

namespace FlexPress\Components\Controller;

abstract class AbstractController
{

    /**
     * @var \Pimple
     */
    protected $dic;

    public function __construct($dic)
    {
        $this->dic = $dic;
    }

    /**
     * Default action for the controller
     *
     * @param $request
     * @return mixed
     * @author Tim Perry
     */
    abstract public function indexAction($request);
}
