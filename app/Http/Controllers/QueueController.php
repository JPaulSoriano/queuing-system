<?php

namespace App\Http\Controllers;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::where('served', false)->orderBy('created_at')->get();
        $nowServing = $queues->first();
    
        return view('queue.index', compact('nowServing', 'queues'));
    }
    public function serveNext()
    {
        $nextQueue = Queue::where('served', false)->orderBy('created_at')->first();
        if ($nextQueue) {
            $nextQueue->update(['served' => true]);
        }
        return redirect()->route('queue.index');
    }
    public function showRegistrationForm()
    {
        return view('queue.register');
    }
    public function create()
    {
        // Get the maximum queue number that hasn't been served yet
        $lastUnservedQueue = Queue::where('served', false)->max('number');
        // Determine the new queue number
        $queueNumber = $lastUnservedQueue !== null ? $lastUnservedQueue + 1 : 1;
        // Create a new queue record
        Queue::create(['number' => $queueNumber]);
        return redirect()->route('queue.register');
    }
    
}
