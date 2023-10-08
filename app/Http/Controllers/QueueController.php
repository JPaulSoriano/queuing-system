<?php

namespace App\Http\Controllers;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::where('served', false)->orderBy('created_at')->get();
        $nowServing = Queue::where('served', true)->where('called_by', Auth::id())->orderBy('updated_at')->get()->last();
        return view('queue.index', compact('nowServing', 'queues'));
    }
    public function serveNext()
    {
        $nextQueue = Queue::where('served', false)->orderBy('created_at')->first();
        if ($nextQueue) {
            $nextQueue->update(['served' => true, 'called_by' => Auth::id()]);
        }
        return redirect()->route('queue.index');
    }
    public function queueForm()
    {
        return view('queue.queueForm');
    }
    public function getQueue()
    {
        $lastUnservedQueue = Queue::where('served', false)->max('number');
        $queueNumber = $lastUnservedQueue !== null ? $lastUnservedQueue + 1 : 1;
        Queue::create(['number' => $queueNumber, 'called_by' => null,]);
        return redirect()->route('queueForm');
    }
    public function customerView()
    {
        $registrars = User::all();
        foreach ($registrars as $registrar) {
            $registrar->currentQueue = Queue::where('served', true)
                ->where('called_by', $registrar->id)
                ->orderBy('updated_at', 'desc')
                ->first();
        }
        $queues = Queue::where('served', false)->orderBy('created_at')->get();
        return view('customer', compact('queues', 'registrars'));
    }
    public function getQueues()
    {
        $queues = Queue::where('served', false)->orderBy('created_at')->get();
        return response()->json(['queues' => $queues]);
    }
    public function getCurrentServing()
    {
        $registrars = User::all();
        foreach ($registrars as $registrar) {
            $registrar->currentQueue = Queue::where('served', true)
                ->where('called_by', $registrar->id)
                ->orderBy('updated_at', 'desc')
                ->first();
        }
        return response()->json(['registrars' => $registrars]);
    }
    

}
