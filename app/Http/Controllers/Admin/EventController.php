<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::orderBy('start_datetime', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime'   => 'nullable|date|after_or_equal:start_datetime',
            'location'       => 'nullable|string|max:255',
            'organizer'      => 'nullable|string|max:255',
            'status'         => 'required|in:upcoming,ongoing,completed,cancelled',
        ], [
            'title.required'          => 'Nama kegiatan wajib diisi.',
            'start_datetime.required' => 'Tanggal mulai wajib diisi.',
            'end_datetime.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        Event::create($request->only([
            'title', 'description', 'start_datetime', 'end_datetime',
            'location', 'organizer', 'status',
        ]));

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime'   => 'nullable|date|after_or_equal:start_datetime',
            'location'       => 'nullable|string|max:255',
            'organizer'      => 'nullable|string|max:255',
            'status'         => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $event->update($request->only([
            'title', 'description', 'start_datetime', 'end_datetime',
            'location', 'organizer', 'status',
        ]));

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda kegiatan berhasil dihapus.');
    }
}
