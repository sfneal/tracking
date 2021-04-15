<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;
use Sfneal\Actions\Action;
use Sfneal\Helpers\Arrays\ArrayHelpers;
use Sfneal\Helpers\Laravel\AppInfo;

class ParseTraffic extends Action
{
    /**
     * Array keys to exclude from the 'request_payload' attribute.
     *
     * @var array
     */
    private const REQUEST_PAYLOAD_EXCLUSIONS = [
        '_token',
        '_method',
        'password',
    ];

    /**
     * @var array
     */
    private $tracking = [];

    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response|RedirectResponse
     */
    private $response;

    /**
     * @var string
     */
    private $time_stamp;

    /**
     * Create a new event instance.
     *
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     * @param string                    $time_stamp todo: add default value
     */
    public function __construct(Request $request, Response $response, string $time_stamp)
    {
        $this->request = $request;
        $this->response = $response;
        $this->time_stamp = $time_stamp;
    }

    /**
     * Execute the action.
     *
     * @return array
     */
    public function execute()
    {
        // Initialize event for serialization
        $this->tracking['user_id'] = intval(auth()->id());
        $this->tracking['session_id'] = Cookie::get(config('session.cookie'));
        $this->tracking['app_version'] = AppInfo::version();
        $this->tracking['time_stamp'] = $this->getTimestamp($this->time_stamp);

        // Request data
        $this->parseRequest();

        // Response data
        $this->parseResponse();

        // Request data
        $this->parseAgent();

        return $this->tracking;
    }

    /**
     * Parse a Request object to retrieve relevant data.
     */
    private function parseRequest()
    {
        $this->tracking['request']['host'] = $this->request->getHttpHost();
        $this->tracking['request']['uri'] = $this->request->getRequestUri();
        $this->tracking['request']['method'] = $this->request->getMethod();
        $this->tracking['request']['payload'] = $this->getRequestPayload();
        $this->tracking['request']['browser'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $this->tracking['request']['ip'] = $this->request->ip();
        $this->tracking['request']['referrer'] = $_SERVER['HTTP_REFERER'] ?? null;
        $this->tracking['request']['token'] = $this->request->get('track_traffic_token') ?? uniqid();
    }

    /**
     * Parse a Response object to retrieve relevant data.
     */
    private function parseResponse()
    {
        $this->tracking['response']['code'] = $this->response->getStatusCode();
        $this->tracking['response']['time'] = $this->getResponseTime($this->time_stamp);

        // Store response content served if enabled
        if (config('tracking.traffic.response_content')) {
            $this->tracking['response']['content'] = $this->response->getContent();
        }
    }

    /**
     * Set user agent data on platform, device & browser.
     */
    private function parseAgent()
    {
        $agent = new Agent();

        $this->tracking['agent']['platform'] = $agent->platform();
        $this->tracking['agent']['device'] = $agent->device();
        $this->tracking['agent']['browser'] = $agent->browser();
    }

    /**
     * Retrieve a request payload with exclusions removed.
     *
     * @return array
     */
    private function getRequestPayload()
    {
        return (new ArrayHelpers(array_merge($this->request->query(), $this->request->input())))
            ->arrayRemoveKeys(self::REQUEST_PAYLOAD_EXCLUSIONS);
    }

    /**
     * Determine the amount of time taken to return a response.
     *
     * @param $time_stamp
     *
     * @return float
     */
    private function getResponseTime($time_stamp)
    {
        return floatval(number_format($time_stamp - LARAVEL_START, 2));
    }

    /**
     * Retrieve a traffic visit occurred at timestamp.
     *
     * @param $time_stamp
     *
     * @return string
     */
    private function getTimestamp($time_stamp)
    {
        return date('Y-m-d H:i:s', $time_stamp);
    }
}
