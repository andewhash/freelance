<!-- resources/views/admin/settings.blade.php -->
@extends('layouts.admin')

@section('content')
    <h1>Настройки</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Значение</th>
            <th>Группа</th>
        </tr>
        </thead>
        <tbody>
        @foreach($settings as $setting)
            <tr>
                <td>{{ $setting->name }}</td>
                <td>{{ $setting->value }}</td>
                <td>{{ $setting->group }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
