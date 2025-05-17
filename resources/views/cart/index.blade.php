@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="text-white fw-bold mb-4">Корзина</h3>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-dark align-middle">
                <thead>
                    <tr>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $item)
                        <tr>
                            <td style="width: 120px;">
                              <img src="{{ asset('storage/knives/' . $item['image']) }}" alt="{{ $item['title'] }}" class="img-fluid rounded" style="max-height: 80px;">
                            </td>
                            <td>{{ $item['title'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $item['price']; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <h4 class="text-white">Итого: ${{ number_format($total, 2) }}</h4>
            <a href="#" class="btn btn-success mt-2">Оформить заказ</a>
        </div>
    @else
        <div class="alert alert-info">Ваша корзина пуста.</div>
    @endif
</div>
@endsection
