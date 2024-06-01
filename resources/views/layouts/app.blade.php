<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .completed-task {
                color: #6c757d; /* dimmer color */
                text-decoration: line-through; /* strikethrough effect */
            }
            html, body {
                font-family: "Roboto", sans-serif !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const taskModal = document.getElementById('taskModal');
        const taskInput = document.getElementById('taskInput');

        taskModal.addEventListener('shown.bs.modal', () => {
            taskInput.focus();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const editableCells = document.querySelectorAll('.editable');

    editableCells.forEach(cell => {
        cell.addEventListener('dblclick', function() {
            if (this.contentEditable === 'false') {
                this.contentEditable = 'true';
                this.focus();
            }
        });

        cell.addEventListener('blur', function() {
            if (this.contentEditable === 'true') {
                updateTaskTitle(this);
                this.contentEditable = 'false'; // Set contentEditable back to false after editing
            }
        });
    });

    function updateTaskTitle(cell) {
        const taskId = cell.getAttribute('data-task-id');
        const newTitle = cell.innerText.trim();

        console.log('Task ID:', taskId); // Debugging

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/tasks/title/${taskId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ title: newTitle })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Network response was not ok (Status: ${response.status}): ${text} for taskId: ${taskId}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Task title updated successfully:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

        window.updateTaskCompletion = function(checkbox, taskId) {
            const isCompleted = checkbox.checked ? 1 : 0;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/tasks/${taskId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ is_completed: isCompleted })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Network response was not ok (Status: ${response.status}): ${text} for taskId: ${taskId}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Task completion status updated successfully:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    </script>
    <script>
    function deleteTask(taskId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Task deleted successfully');
            // Optionally refresh the page or remove the row from the table
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
</script>
   
</html>
