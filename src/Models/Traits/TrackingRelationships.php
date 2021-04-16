<?php

namespace Sfneal\Tracking\Models\Traits;

use Domain\Plans\Models\Plan;
use Domain\Plans\Models\PlanManagement;
use Domain\Projects\Models\Project;
use Domain\Tasks\Models\Task;
use Domain\Tasks\Models\TaskRecord;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// todo: move this back to hpa app
trait TrackingRelationships
{
    /**
     * Retrieve the TrackActivity instances Plan model if one exists.
     *
     * @return mixed|null
     */
    public function model()
    {
        // Plan
        if ($this->model_table == 'plan') {
            return $this->plan;
        } elseif (inString($this->model_table, 'plan_management')) {
            // Return Plan model if it exists
            if ($this->planManagement->plan) {
                return $this->planManagement->plan;
            }

            // Otherwise return the Project model
            else {
                return $this->planManagement->project;
            }
        }

        // Project
        elseif ($this->model_table == 'project') {
            return $this->project;
        }

        // Task
        elseif ($this->model_table == 'task_record' && $this->taskRecord && $this->taskRecord->task && $this->taskRecord->task->project) {
            return $this->taskRecord->task->project;
        } elseif ($this->model_table == 'task' && $this->task && $this->task->project) {
            return $this->task->project;
        }

        return null;
    }

    /**
     * Retrieve a route for this model.
     *
     * @return string
     */
    public function modelRoute()
    {
        // Plan
        if ($this->model() instanceof Plan) {
            return route('plans.plan.show', ['plan'=>$this->model()->getKey(), 'modal'=>1]);
        }

        // Project
        elseif ($this->model() instanceof Project) {
            return route('projects.show', ['project'=>$this->model()->getKey()]);
        }
    }

    /**
     * Retrieve the link class.
     *
     * @return string
     */
    public function linkClass(): string
    {
        if ($this->model() instanceof Plan) {
            return 'modal-link';
        } else {
            return '';
        }
    }

    /**
     * Plan relationship.
     *
     * @return BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'model_key', 'plan_id');
    }

    /**
     * Plan management relationship.
     *
     * @return BelongsTo
     */
    public function planManagement()
    {
        return $this->belongsTo(PlanManagement::class, 'model_key', 'project_id');
    }

    /**
     * Project relationship.
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'model_key', 'project_id');
    }

    /**
     * Task relationship.
     *
     * @return BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'model_key', 'task_id');
    }

    /**
     * Task relationship.
     *
     * @return BelongsTo
     */
    public function taskRecord()
    {
        return $this->belongsTo(TaskRecord::class, 'model_key', 'record_id');
    }
}
