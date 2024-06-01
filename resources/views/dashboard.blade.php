<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To Do List!') }}
        </h2>
    </x-slot>

    <div class="pt-3">
        <div class="row col-md-6 offset-md-3 bg-white shadow rounded-3">
            <div class="d-flex justify-content-end pt-2 pr-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                    Create New Task
                </button>
            </div>

            @if(!empty($task) && $task->count() > 0)
            <div class="table-responsive">
            <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-muted">
                        <th>Title</th>
                        <th>Check</th>
                        <th></th>
                    </tr>
                </thead>        
            <tbody>
                @foreach($task as $tasks)
                <tr class="{{ $tasks->is_completed ? 'completed-task' : '' }}">
                    <td class="editable" contenteditable="false" data-task-id="{{ $tasks->id }}">{{ $tasks->title }}</td>
                    <td>
                    <input type="checkbox" class="ma" name="is_completed" {{ $tasks->is_completed ? 'checked' : '' }} onchange="updateTaskCompletion(this, {{ $tasks->id }})">
                    </td>
                    <td><form method="POST" action="{{ route('tasks.delete', $tasks->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form></td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        @else
            <p>No tasks found.</p>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="taskModalLabel">Task title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addTaskForm" method="POST" action="{{ route('tasks.add') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="taskInput" name="task_title" class="form-control" placeholder="Enter task title" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        
</x-app-layout>
