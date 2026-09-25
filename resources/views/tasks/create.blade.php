<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>

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
            max-width: 850px;
            margin: auto;
        }

        .header h2 {
            margin: 0;
            font-size: 21px;
        }

        .header p {
            margin: 5px 0 0;
            color: #bfd0df;
            font-size: 13px;
        }

        .container {
            max-width: 760px;
            margin: 40px auto;
            padding: 0 22px 50px;
        }

        .page-title {
            margin-bottom: 20px;
        }

        .page-title h1 {
            margin: 0 0 7px;
            color: #17324d;
            font-size: 28px;
        }

        .page-title p {
            margin: 0;
            color: #718294;
        }

        .form-card {
            background: white;
            border: 1px solid #dce6ef;
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 5px 18px rgba(30, 50, 70, 0.06);
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #30495f;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #ccd8e2;
            border-radius: 8px;
            background: #fbfdff;
            color: #25384a;
            font-size: 14px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.12);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            padding-top: 18px;
            border-top: 1px solid #e8eef3;
        }

        .save-button,
        .cancel-button {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .save-button {
            border: none;
            background: #1976d2;
            color: white;
            cursor: pointer;
        }

        .cancel-button {
            background: #edf3f8;
            color: #536b7d;
            border: 1px solid #d5e0e8;
        }

        .error-box {
            background: #ffe8e8;
            border: 1px solid #efbcbc;
            color: #963838;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 650px) {
            .row {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="header">
    <div class="header-inner">
        <h2>Personal Task Manager</h2>
        <p>Plan it. Track it. Finish it.</p>
    </div>
</div>

<div class="container">

    <div class="page-title">
        <h1>Create New Task</h1>
        <p>Add the information for your new task.</p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <strong>Please check the following:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="task_name">Task Name</label>

                <input
                    id="task_name"
                    type="text"
                    name="task_name"
                    value="{{ old('task_name') }}"
                    placeholder="Enter task name"
                    required>
            </div>

            <div class="field">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Enter task description">{{ old('description') }}</textarea>
            </div>

            <div class="row">

                <div class="field">
                    <label for="status">Status</label>

                    <select id="status" name="status" required>
                        <option value="Pending" {{ old('status', 'Pending') === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label for="due_date">Due Date</label>

                    <input
                        id="due_date"
                        type="date"
                        name="due_date"
                        value="{{ old('due_date') }}"
                        required>
                </div>

            </div>

            <div class="buttons">

                <button type="submit" class="save-button">
                    Create Task
                </button>

                <a href="{{ route('tasks.index') }}" class="cancel-button">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
