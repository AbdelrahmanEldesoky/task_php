<!DOCTYPE html>
<html>

<head>
    <title>Add New Task</title>
</head>

<body>
    <h1>Add New Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <label for="title">Task Title:</label>
        <input type="text" name="title" id="title" required maxlength="100">
        <br>
        <button type="submit">Add Task</button>
    </form>
</body>

</html>
