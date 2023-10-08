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
    
    public function create()
    {
        $lastQueueNumber = Queue::max('number') ?? 0;
        $queue = Queue::create([
            'number' => $lastQueueNumber + 1,
        ]);
    
        return redirect()->route('queue.index');
    }
}
