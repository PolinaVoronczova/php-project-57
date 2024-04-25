@extends('layouts.app')
@section('title', 'Задачи')
@section('content')
<section>
<div class="w-full flex items-center">
    {{ Form::model($tasks, ['route' => ['tasks.index', $tasks], 'method' => 'GET']) }}
    {{ Form::select('filter[status_id]', $taskStatuses, $filter['status_id'] ?? '', ['placeholder' => 'Статус', 'class' => 'rounded border-blue-300 mb-1']) }}
    {{ Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? '', ['placeholder' => 'Автор', 'class' => 'rounded border-blue-300 mb-1']) }}
    {{ Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? '', ['placeholder' => 'Исполнитель', 'class' => 'rounded border-blue-300 mb-1']) }}
    {{ Form::submit('Применить', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
    {{ Form::close() }}
</div>
        <div class="grid max-w-screen-xl pt-10 pb-10 mx-auto lg:gap-8 xl:gap-0 lg:py-10 lg:grid-cols-12">
            <div class="grid col-span-full">
                @auth
                    <div>
                        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Создать задачу
                        </a>
                    </div>
                @endauth
                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>Статус</th>
                            <th>Имя</th>
                            <th>Автор</th>
                            <th>Исполнитель</th>
                            <th>Дата создания</th>
                            <th>
                                @auth
                                Действия
                                @endauth
                            </th>
                        </tr>
                    </thead>
                    @foreach ($tasks as $task)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->taskStatus->name }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}"
                                    class="align-middle text-green-500">{{ $task->name }}
                                </a>
                            </td>
                            <td>{{ $task->creator->name }}</td>
                            <td>{{ $task->executor->name ?? '' }}</td>
                            <td>{{ $task->created_at->format('d.m.Y') }}</td>
                            <td>
                                @auth
                                    @if (auth()->user()->id === $task->creator->id)
                                        <a data-method="delete" data-confirm="Вы уверены?" href="{{ route('tasks.destroy', $task) }}" class="text-red-600 hover:text-red-900">
                                            Удалить
                                        </a>
                                    @endif
                                    <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.edit', $task) }}">
                                        Изменить
                                    </a>
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </section>
    </section>
@endsection