<?php

namespace Cos\RestClientBundle\Request\Options;


class RequestOptionsCollection
{
    /**
     * @var RequestOptionInterface[]
     */
    private $options;

    public function register(RequestOptionInterface $option)
    {
        $this->options[] = $option;
    }

    public function getOptions()
    {
        return $this->options;
    }
}