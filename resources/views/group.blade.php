<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To Do List!') }}
        </h2>
    </x-slot>

    <div class="pt-3 row">
        <div class="col-md-2 offset-md-2 bg-white rounded-start border-end">
            <div class=" pt-4 pb-2">
                <div class="row">
                    <div class="col">
                        <p class="font-weight-bold h4 mb-0 pt-2">{{ $group->title }}</p>
                    </div>
                    <div class="col-2">
                        <form method="GET" action="{{ route('dashboard')}}" style="display:inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btnback"><i class="bi bi-arrow-left-square"></i></button>
                        </form>
                    </div>
                    <div class="col-3">
                        <form method="POST" action="{{ route('groups.delete', $group->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btndel"><i class="bi bi-trash"></i></button>
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
                        <input type="text" id="taskInput" name="task_title" class="form-control" placeholder="Add List. Press Enter to save" required>
                        <input type="hidden" id="groupId" name="group_id" class="form-control" value="{{ $group->id }}">
                    </div>
                </form>
            </div>
            @if(!empty($taskwGroup) && $taskwGroup->count() > 0)
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
                    @foreach($taskwGroup as $tasks)
                    <tr class="{{ $tasks->is_completed ? 'completed-task' : '' }}">    
                        <td class="col-1"><input type="checkbox" name="is_completed" {{ $tasks->is_completed ? 'checked' : '' }} onchange="updateTaskCompletion(this, {{ $tasks->id }})"></td>       
                        <td class="editable" contenteditable="false" data-task-id="{{ $tasks->id }}">{{ $tasks->title }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('tasks.delete', $tasks->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btndel"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
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