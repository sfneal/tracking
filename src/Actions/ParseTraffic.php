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
    private $timestamp;

    /**
     * Create a new event instance.
     *
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     * @param string|null               $timestamp
     */
    public function __construct(Request $request, $response, string $timestamp = null)
    {
        $this->request = $request;
        $this->response = $response;
        $this->timestamp = $timestamp ?? microtime();
    }

    /**
     * Execute the action.
     *
     * @return array
     */
    public function execute(): array
    {
        // Initialize event for serialization
        $this->tracking['user_id'] = intval(auth()->id());
        $this->tracking['session_id'] = Cookie::get(config('session.cookie'));
        $this->tracking['app_version'] = AppInfo::version();
        $this->tracking['time_stamp'] = self::getTimestamp($this->timestamp);

        // Request data
        $this->tracking['request'] = $this->parseRequest();

        // Response data
        $this->tracking['response'] = $this->parseResponse();

        // Request data
        $this->tracking['agent'] = $this->parseAgent();

        return $this->tracking;
    }

    /**
     * Parse a Request object to retrieve relevant data.
     *
     * @return array
     */
    public function parseRequest(): array
    {
        return [
            'host' => $this->request->getHttpHost(),
            'uri' => $this->request->getRequestUri(),
            'method' => $this->request->getMethod(),
            'payload' => $this->getRequestPayload(),
            'browser' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'ip' => $this->request->ip(),
            'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
            'token' => $this->request->get('track_traffic_token') ?? uniqid(),
        ];
    }

    /**
     * Parse a Response object to retrieve relevant data.
     *
     * @return array
     */
    public function parseResponse(): array
    {
        // Status code & response time
        $response = [
            'code' => $this->response->getStatusCode(),
            'time' => self::getResponseTime($this->timestamp),
        ];

        // Store response content served if enabled
        if (config('tracking.traffic.response_content')) {
            $response['content'] = $this->response->getContent();
        }

        return $response;
    }

    /**
     * Set user agent data on platform, device & browser.
     *
     * @return array
     */
    public function parseAgent(): array
    {
        $agent = new Agent();

        return [
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'browser' => $agent->browser(),
        ];
    }

    /**
     * Retrieve a request payload with exclusions removed.
     *
     * @return array
     */
    private function getRequestPayload(): array
    {
        return ArrayHelpers::from(array_merge($this->request->query(), $this->request->input()))
            ->removeKeys(self::REQUEST_PAYLOAD_EXCLUSIONS)
            ->get();
    }

    /**
     * Determine the amount of time taken to return a response.
     *
     * @param string $timestamp
     *
     * @return float
     */
    private static function getResponseTime(string $timestamp): float
    {
        return floatval(number_format($timestamp - LARAVEL_START, 2));
    }

    /**
     * Retrieve a traffic visit occurred at timestamp.
     *
     * @param string $timestamp
     *
     * @return string
     */
    private static function getTimestamp(string $timestamp): string
    {
        return date('Y-m-d H:i:s', $timestamp);
    }
}
