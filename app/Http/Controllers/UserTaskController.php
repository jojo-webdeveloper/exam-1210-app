<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class UserTaskController
{

    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return View
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $allowedSortableFields = ['title', 'date_created'];
        $sortField = in_array($request->get('sort_field'), $allowedSortableFields) ? $request->get('sort_field') : 'date_created';
        $direction = $request->get('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        $tasks = UserTask::with('subTasks')
            ->where('created_by', auth()->id())
            ->where('publish_status', '<>', 'trashed')
            ->where('parent_id')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status, fn($q) => $q->where('task_status', $status))
            ->orderBy($sortField, $direction)
            ->paginate($perPage)
            ->appends($request->except('page'));

      
        return view('user_tasks.index', compact('tasks', 'search', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     * 
     * @return View      
     */
    public function create()
    {

        $parentOptions = UserTask::where('created_by', auth()->id())
        ->orderBy('title')
        ->pluck('title', 'id');

        //return view('user_tasks.create');
        return view('user_tasks.create', compact('parentOptions'));
    }


    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100', 'unique:user_task,title'],
            'content' => 'required',
            'task_status' => 'required|in:done,inprogress,todo',
            'publish_status' => 'required|in:draft,published',
            'parent_id' => 'nullable|exists:user_task,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data['created_by'] = auth()->id();

        // Handle file upload if exists
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['attachment'] = $filename;
        }

        UserTask::create($data);

        return redirect()->route('user_tasks.index')
            ->with('success', 'Task created.');
    }


    /**
     * Display the specified resource.
     * 
     * @param \App\Models\UserTask  $userTask
     * @return View
     */
    public function show(UserTask $userTask)
    {
        return view('user_tasks.show', compact('userTask'));
    }


    /**
     * Show the form for editing the specified resource.
     * 
     * @param \App\Models\UserTask  $userTask
     * @return View
     */
    public function edit(UserTask $userTask)
    {

    $parentOptions = UserTask::where('created_by', auth()->id())
        ->where('id', '<>', $userTask->id)
        ->orderBy('title')
        ->pluck('title','id');

        return view('user_tasks.edit', compact('userTask', 'parentOptions'));
    }


    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\UserTask  $userTask
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, UserTask $userTask)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('user_task', 'title')->ignore($userTask->id),
            ],
            'content' => 'required',
            'task_status' => 'nullable|in:done,inprogress,todo',
            'publish_status' => 'required|in:draft,published',
            'parent_id' => 'nullable|exists:user_task,id',
        ]);

        // Handle file upload if exists
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['attachment'] = $filename;
        }

        $userTask->update($data + ['date_updated' => now()]);
        return redirect()->route('user_tasks.index')
            ->with('success', 'Task updated.');
    }


    /**
     * Marked the tas as trashed.
     * 
     * @param \App\Models\UserTask  $userTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function trash(UserTask $userTask)
    {
        $userTask->update(['publish_status' => 'trashed']);
        return redirect()->route('user_tasks.index')
            ->with('success', 'Task moved to trash.');
    }


    /**
     * Remove the specified resource from storage.
     * 
     * @param \App\Models\UserTask  $userTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserTask $userTask)
    {
        $userTask->delete();
        return redirect()->route('user_tasks.index')
            ->with('success', 'Task deleted.');
    }
}
