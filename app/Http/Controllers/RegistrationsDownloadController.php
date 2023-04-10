<?php

namespace App\Http\Controllers;

use App\Exports\RegistrationsExport;
use App\Models\Event;
use Excel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegistrationsDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event): BinaryFileResponse
    {
        $this->authorize('seeRegistrations', Event::class);

        $eventName = $event->name;

        return Excel::download(new RegistrationsExport($event), "$eventName.xlsx");
    }
}
