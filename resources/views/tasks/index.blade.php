<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>

</head>

<body>
    <h1>Task Manager</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <ul>
        @foreach($tasks as $task)
            <li>
                <span class="task-title" data-task-id="{{ $task['id'] }}">{{ $task['title']}}</span>
                <form action="{{ route('tasks.destroy', $task['id']) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('tasks.create') }}">Add New Task</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // AJAX interaction for inline editing
        $(document).ready(function() {
            $('.task-title').on('click', function() {
                var taskId = $(this).data('task-id');
                var taskTitle = $(this).text();
                var newTitle = prompt('Edit task title:', taskTitle);

                if (newTitle !== null) {
                    $.ajax({
                        url: '/tasks/' + taskId,
                        type: 'PUT',
                        data: {
                            title: newTitle
                        },
                        success: function(response) {
                            $(this).text(newTitle);
                            alert(response.success);
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.error);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
