@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{ Form::label('name', 'Имя') }}
{{ Form::text('name', (isset($task)) ? $task->name : '') }}<br>
{{ Form::label('description', 'Описание') }}
{{ Form::textarea('description', (isset($task)) ? $task->description : '') }}<br>
{{ Form::label('status_id', 'Статус') }}
{{ Form::select('status_id', $task_statuses) }}<br>
{{ Form::label('assigned_to_id', 'Исполнитель') }}
{{ Form::select('assigned_to_id', $users) }}<br>
{{ Form::label('labels', 'Метки') }}
{{ Form::select('labels[]', $labels, isset($labels[0])? : '', array('multiple' => true)) }}<br>