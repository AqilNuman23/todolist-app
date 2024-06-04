<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To Do List!') }}
        </h2>
    </x-slot>

    <div class="pt-3 row">
        <div class="col-md-2 offset-md-2 bg-white rounded-start border-end">
            <div class="row pt-4">
                <div class="row">
                    <div class="col">
                        <p class="font-weight-bold h4 mb-0 pt-2">Category</p>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn buttonset" data-bs-toggle="modal" data-bs-target="#groupModal">
                        +                                                              
                        </button>
                    </div>
                </div>
                <div class="row pt-3">
                @if(!empty($group) && $group->count() > 0)
                    @foreach($group as $groups)
                        <form action="{{ route('group.show', ['id'=>$groups->id]) }}" method="GET">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $groups->id }}">
                        <button type="submit" class="btn buttonset">{{ $groups->title }}</button>
                        </form>
                    @endforeach
                @else
                    <p class="fst-italic text-secondary">Add one!</p>
                @endif
                </div>
            
            </div>

            <!-- Modal Group -->
            <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="groupModalLabel">Add Category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="addGroupForm" method="POST" action="{{ route('groups.create') }}">
                            @csrf
                            <div class="modal-body">
                                <input type="text" id="groupInput" name="group_title" class="form-control" placeholder="Title" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 bg-white rounded-end">
          
            <div class="pt-4">
                <form id="addTaskForm" method="POST" action="{{ route('tasks.create') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="taskInput" name="task_title" class="form-control" placeholder="Add task. Press Enter to save" required>
                    </div>
                </form>
            </div>
            
            @if(!empty($task) && $task->count() > 0)
            <div class="table-responsive">
                <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th>List</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>        
                    <tbody>
                        @foreach($task as $tasks)
                        <tr class="{{ $tasks->is_completed ? 'completed-task' : '' }}">
                            <td class="col-1"><input type="checkbox" name="is_completed" {{ $tasks->is_completed ? 'checked' : '' }} onchange="updateTaskCompletion(this, {{ $tasks->id }})"></td>
                            <td class="editable" contenteditable="false" data-task-id="{{ $tasks->id }}">{{ $tasks->title }}</td>
                            <td class="text-end"><form method="POST" action="{{ route('tasks.delete', $tasks->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btndel"><i class="bi bi-trash"></i></button>
                        </form></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center pt-4 pb-4 font-italic">
                <p class="fst-italic text-secondary">You all good!</p>
            </div>
            @endif
        </div>
        
    </div>
        
</x-app-layout>
