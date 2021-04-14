<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficFactoryTest extends FactoriesTestCase implements FactoryFillablesTest
{
    /**
     * @var TrackTraffic
     */
    public $modelClass = TrackTraffic::class;

    /** @test */
    public function fillables_are_correct_types()
    {
        $this->assertIsInt($this->model->getKey());

        $this->assertIsInt($this->model->track_traffic_id);
        $this->assertIsInt($this->model->user_id);
        $this->assertIsString($this->model->session_id);

        // Application
        $this->assertIsString($this->model->app_version);
        $this->assertIsString($this->model->app_environment);

        // Request
        $this->assertIsString($this->model->request_host);
        $this->assertIsString($this->model->request_uri);
        $this->assertIsString($this->model->request_method);
        $this->assertIsArray($this->model->request_payload);
        if ($this->model->request_browser) {
            $this->assertIsString($this->model->request_browser);
        }
        $this->assertIsString($this->model->request_ip);
        if ($this->model->request_referrer) {
            $this->assertIsString($this->model->request_referrer);
        }
        $this->assertIsString($this->model->request_token);

        // Response
        $this->assertIsInt($this->model->response_code);
        $this->assertIsFloat($this->model->response_time);
        if ($this->model->response_content) {
            $this->assertIsString($this->model->response_content);
        }

        // Agent
        $this->assertIsString($this->model->agent_platform);
        $this->assertIsString($this->model->agent_device);
        $this->assertIsString($this->model->agent_browser);

        $this->assertIsString($this->model->time_stamp);
    }
}
