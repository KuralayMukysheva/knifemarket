@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card position-relative">
                <!-- Кнопка-крестик -->
                <a href="{{ route('knives.index') }}" class="position-absolute top-0 end-0 m-2 text-decoration-none">
                    <button type="button" class="btn-close" aria-label="Закрыть"></button>
                </a>

                <div class="card-header text-white">Добавить нож</div>
                <div class="card-body text-white">
                    <form method="POST" action="{{ route('knives.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Название</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Цена</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение ножа</label>
                            <input class="form-control" type="file" id="image" name="image" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
