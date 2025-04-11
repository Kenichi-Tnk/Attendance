<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AttendanceList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $attendances;
    public $currentMonth;
    public $previousLink;
    public $nextLink;
    public $isAdmin;
    public $csvLink;

    public function __construct($title, $attendances, $currentMonth, $previousLink, $nextLink, $isAdmin = false, $csvLink = null)
    {
        $this->title = $title;
        $this->attendances = $attendances;
        $this->currentMonth = $currentMonth;
        $this->previousLink = $previousLink;
        $this->nextLink = $nextLink;
        $this->isAdmin = $isAdmin;
        $this->csvLink = $csvLink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.attendance-list');
    }
}
