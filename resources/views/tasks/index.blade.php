<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyle's Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #eef3f8;
            color: #1e293b;
        }

        .header {
            background: #17324d;
            color: white;
            padding: 22px 30px;
        }

        .header-inner {
            max-width: 1100px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand h2 {
            margin: 0;
            font-size: 21px;
        }

        .brand p {
            margin: 5px 0 0;
            color: #bfd0df;
            font-size: 13px;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 22px 50px;
        }

        .intro {
            background: white;
            border-radius: 16px;
            padding: 26px;
            margin-bottom: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 5px 18px rgba(30, 50, 70, 0.07);
        }

        .intro h1 {
            margin: 0 0 8px;
            font-size: 28px;
            color: #17324d;
        }

        .intro p {
            margin: 0;
            color: #6b7c8d;
        }

        .add-button {
            background: #1976d2;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 9px;
            font-weight: bold;
            white-space: nowrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 13px;
            padding: 20px;
            border-left: 5px solid #1976d2;
            box-shadow: 0 4px 14px rgba(30, 50, 70, 0.05);
        }

        .stat-label {
            color: #708090;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #17324d;
        }

        .success {
            background: #e7f7ed;
            border: 1px solid #adddbd;
            color: #216b3d;
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .section-title {
            margin: 0 0 14px;
            color: #17324d;
            font-size: 19px;
        }

        .task-list {
            display: grid;
            gap: 14px;
        }

        .task-card {
            background: white;
            border-radius: 13px;
            padding: 20px;
            box-shadow: 0 4px 14px rgba(30, 50, 70, 0.05);
            border: 1px solid #dce6ef;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
        }

        .task-name {
            margin: 0 0 7px;
            color: #17324d;
            font-size: 19px;
        }

        .task-description {
            margin: 0;
            color: #728292;
            line-height: 1.5;
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fff1cc;
            color: #916800;
        }

        .completed {
            background: #dff4e8;
            color: #257044;
        }

        .details {
            margin-top: 14px;
            color: #7a8998;
            font-size: 13px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 17px;
            padding-top: 15px;
            border-top: 1px solid #e8eef3;
        }

        .actions form {
            margin: 0;
        }

        .actions button,
        .edit-button {
            border: none;
            border-radius: 7px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .status-button {
            background: #e2f0ff;
            color: #1762a8;
        }

        .edit-button {
            background: #f0eaff;
            color: #6545a5;
        }

        .delete-button {
            background: #ffe7e7;
            color: #a63d3d;
        }

        .empty {
            background: white;
            border: 2px dashed #c8d5df;
            border-radius: 13px;
            padding: 50px 20px;
            text-align: center;
        }

        .empty h3 {
            margin: 0 0 8px;
            color: #17324d;
        }

        .empty p {
            margin: 0;
            color: #7a8998;
        }

        @media (max-width: 700px) {
            .intro,
            .task-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .add-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="header">
    <div class="header-inner">
        <div class="brand">
            <h2>Personal Task Manager</h2>
            <p>Plan it. Track it. Finish it.</p>
        </div>
    </div>
</div>

<div class="container">

    <div class="intro">
        <div>
            <h1>My Task Board</h1>
            <p>Manage your deadlines and keep your work organized.</p>
        </div>

        <a href="{{ route('tasks.create') }}" class="add-button">
            + New Task
        </a>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="stats">

        <div class="stat-card">
            <div class="stat-label">TOTAL TASKS</div>
            <div class="stat-number">{{ $tasks->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">PENDING TASKS</div>
            <div class="stat-number">
                {{ $tasks->where('status', 'Pending')->count() }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">COMPLETED TASKS</div>
            <div class="stat-number">
                {{ $tasks->where('status', 'Completed')->count() }}
            </div>
        </div>

    </div>

    <h2 class="section-title">Task List</h2>

    <div class="task-list">

        @forelse ($tasks as $task)

            <div class="task-card">

                <div class="task-header">

                    <div>
                        <h3 class="task-name">
                            {{ $task->task_name }}
                        </h3>

                        <p class="task-description">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <span class="status {{ $task->status === 'Completed' ? 'completed' : 'pending' }}">
                        {{ $task->status }}
                    </span>

                </div>

                <div class="details">
                    Due: {{ $task->due_date->format('M d, Y') }}
                    &nbsp; • &nbsp;
                    Task #{{ $task->id }}
                </div>

                <div class="actions">

                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <input
                            type="hidden"
                            name="status"
                            value="{{ $task->status === 'Completed' ? 'Pending' : 'Completed' }}">

                        <button class="status-button" type="submit">
                            {{ $task->status === 'Completed' ? 'Mark Pending' : 'Mark Completed' }}
                        </button>
                    </form>

                    <a href="{{ route('tasks.edit', $task) }}" class="edit-button">
                        Edit
                    </a>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="delete-button" type="submit">
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="empty">
                <h3>Your task list is empty</h3>
                <p>Click New Task to create your first task.</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
