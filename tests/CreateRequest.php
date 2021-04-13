<?php

namespace Sfneal\Tracking\Tests;

use Illuminate\Http\Request;

trait CreateRequest
{
    /**
     * Create a Request to be used in test methods.
     *
     * @param array $headers
     * @return Request
     */
    protected function createRequest(array $headers = []): Request
    {
        $request = Request::create('/', 'GET', [], [], [], [], []);

        foreach ($headers as $header => $value) {
            $request->headers->set($header, $value);
        }

        return $request;
    }
}
