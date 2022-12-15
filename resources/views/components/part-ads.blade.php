@inject('promotions', 'App\Models\Promotion')

@foreach($promotions->query()->where('status', '1')->inRandomOrder()->limit($attributes['limit'])->get() as $post)
    @if($post->ads_type == 'video')
        @continue
    @endif

    <!-- card -->
    <div class="col-md-3">
        <div class="card">
            <div class="card__cover">
                <img src="{{ $post->material }}" width="160" height="237" style="object-fit: cover;" alt="{{ $post->material }}">
            </div>
            
        </div>
    </div>
    <!-- end card -->
@endforeach