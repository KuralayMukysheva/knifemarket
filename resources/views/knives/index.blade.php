@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white fw-bold mb-4">Каталог ножей</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                <i class="bi bi-cart-fill"></i>
                @if(session('cart_total'))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        ${{ number_format(session('cart_total'), 2) }}
                    </span>
                @endif
            </a>
            <a href="{{ route('knives.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<form method="GET" action="{{ route('knives.index') }}" class="row mb-4 g-2">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по названию или описанию...">
    </div>
    <div class="col-md-3">
        <input type="number" step="0.01" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Мин. цена">
    </div>
    <div class="col-md-3">
        <input type="number" step="0.01" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Макс. цена">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-light w-100">Найти</button>
    </div>
</form>

    <div class="row">
        @foreach($knives as $knife)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/knives/' . $knife->image) }}" class="card-img-top" alt="{{ $knife->title }}" style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title text-white">{{ $knife->title }}</h5>
                    <p class="card-text text-white">{{ $knife->description }}</p>
                    <p class="text-success">${{ number_format($knife->price, 2) }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between">
                      
                        <button class="btn btn-sm btn-outline-primary edit-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal"
                                data-id="{{ $knife->id }}"
                                data-title="{{ $knife->title }}"
                                data-description="{{ $knife->description }}"
                                data-price="{{ $knife->price }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>

                        <form method="POST" action="{{ route('cart.add', $knife->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-cart-plus-fill"></i>
                            </button>
                        </form>

                        <button class="btn btn-sm btn-outline-danger delete-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal"
                                data-id="{{ $knife->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Подтверждение удаления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">Вы уверены, что хотите удалить этот нож?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                <button type="submit" class="btn btn-danger">Да, удалить</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Редактирование ножа</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editTitle" class="form-label">Название</label>
                    <input type="text" class="form-control" id="editTitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="editDescription" class="form-label">Описание</label>
                    <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="editPrice" class="form-label">Цена</label>
                    <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="editImage" class="form-label">Изображение</label>
                    <input class="form-control" type="file" id="editImage" name="image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>

<script>

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const knifeId = this.getAttribute('data-id');
            document.getElementById('deleteForm').action = `/knives/${knifeId}`;
        });
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const knifeId = this.getAttribute('data-id');
            document.getElementById('editForm').action = `/knives/${knifeId}`;
            document.getElementById('editTitle').value = this.getAttribute('data-title');
            document.getElementById('editDescription').value = this.getAttribute('data-description');
            document.getElementById('editPrice').value = this.getAttribute('data-price');
        });
    });
</script>
@endsection
