@inject('promotions', 'App\Models\Promotion')

<div class="col-12 col-lg-4 col-xl-4">
    <div class="row">
        <!-- section title -->
        <div class="col-12">
            <h2 class="section__title section__title--sidebar">Sponsored Content</h2>
        </div>
        <!-- end section title -->

        @foreach($promotions->query()->where('status', '1')->inRandomOrder()->limit(6)->get() as $promotion)
            @if($promotion->ads_type == 'video')
                @continue
            @endif
            <!-- card -->
            <div class="col-6 col-sm-4 col-lg-6">
                <div class="card">
                    <div class="card__cover">
                        <img src="{{ $promotion->material }}" style="width: 160px; height: 237px; object-fit: cover;" alt="">
                    </div>
                    <div class="card__content">
                        <h3 class="card__title">{{ $promotion->title }}</h3>
                    </div>
                </div>
            </div>
            <!-- end card -->
        @endforeach

    </div>
</div>