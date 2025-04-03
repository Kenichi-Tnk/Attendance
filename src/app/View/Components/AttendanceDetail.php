<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AttendanceDetail extends Component
{
    public $attendance;
    public $action;
    public $isAdmin;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($attendance, $action, $isAdmin)
    {
        $this->attendance = $attendance;
        $this->action = $action;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.attendance-detail');
    }
}
