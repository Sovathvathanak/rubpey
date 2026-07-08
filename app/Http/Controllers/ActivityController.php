<?php

namespace App\Http\Controllers;

class ActivityController extends Controller
{
    public function index()
    {
        return view('activity.index', $this->shell([
            'activities' => $this->bank()->activitiesFor($this->customerId()),
        ]));
    }

    public function markAllRead()
    {
        $this->bank()->markActivitiesRead($this->customerId());

        return redirect()->route('activity.index');
    }
}
