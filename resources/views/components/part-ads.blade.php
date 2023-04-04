@inject('promotions', 'App\Models\Promotion')

@foreach($promotions->query()->
    where('status', '1')->whereDate('expires_at', '>=', \Carbon\Carbon::today())->
    inRandomOrder()->limit($attributes['limit'])->get() as $post)

    @if($post->ads_type == 'video')
        @continue
    @endif

    <!-- item -->
    <div class="item" style="margin-right: 8px;">
        <img src="{{ $post->material }}" width="160" height="237" style="object-fit: cover;" alt="{{ $post->material }}">
    </div>
    <!-- end item -->

@endforeach