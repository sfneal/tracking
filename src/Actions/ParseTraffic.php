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

// todo: optimize execute method
class ParseTraffic extends Action
{
    /**
     * @var array
     */
    private $tracking = [];

    /**
     * Array keys to exclude from the 'request_payload' attribute.
     *
     * @var array
     */
    private $request_payload_exclusions = [
        '_token',
        '_method',
        'password',
    ];

    /**
     * Create a new event instance.
     *
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     * @param string                    $time_stamp todo: add default value
     */
    public function __construct(Request $request, Response $response, string $time_stamp)
    {
        // Initialize event for serialization
        $this->tracking['user_id'] = intval(auth()->id());
        $this->tracking['session_id'] = Cookie::get(config('session.cookie'));
        $this->tracking['app_version'] = AppInfo::version();
        $this->tracking['time_stamp'] = $this->getTimestamp($time_stamp);

        // Request data
        $this->parseRequest($request);

        // Response data
        $this->parseResponse($response, $time_stamp);

        // Request data
        $this->parseAgent();
    }

    /**
     * Execute the action.
     *
     * @return array
     */
    public function execute()
    {
        return $this->tracking;
    }

    /**
     * Parse a Request object to retrieve relevant data.
     *
     * @param Request $request
     */
    private function parseRequest(Request $request)
    {
        $this->tracking['request']['host'] = $request->getHttpHost();
        $this->tracking['request']['uri'] = $request->getRequestUri();
        $this->tracking['request']['method'] = $request->getMethod();
        $this->tracking['request']['payload'] = $this->getRequestPayload($request);
        $this->tracking['request']['browser'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $this->tracking['request']['ip'] = $request->ip();
        $this->tracking['request']['referrer'] = $_SERVER['HTTP_REFERER'] ?? null;
        $this->tracking['request']['token'] = $request->get('track_traffic_token') ?? uniqid();
    }

    /**
     * Parse a Response object to retrieve relevant data.
     *
     * @param Response|RedirectResponse $response
     * @param $time_stamp
     */
    private function parseResponse($response, $time_stamp)
    {
        $this->tracking['response']['code'] = $response->getStatusCode();
        $this->tracking['response']['time'] = $this->getResponseTime($time_stamp);

        // Store response content served if enabled
        if (config('tracking.traffic.response_content')) {
            $this->tracking['response']['content'] = $response->getContent();
        }
    }

    private function parseAgent()
    {
        $agent = new Agent();

        $this->tracking['agent']['platform'] = $agent->platform();
        $this->tracking['agent']['device'] = $agent->device();
        $this->tracking['agent']['browser'] = $agent->browser();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function getRequestPayload(Request $request)
    {
        return (new ArrayHelpers(array_merge($request->query(), $request->input())))
            ->arrayRemoveKeys($this->request_payload_exclusions);
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
     * @param $time_stamp
     *
     * @return string
     */
    private function getTimestamp($time_stamp)
    {
        return date('Y-m-d H:i:s', $time_stamp);
    }
}
