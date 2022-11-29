<ul id="pricing_list">
    @foreach($pricing as $item)
    <li>
        @if($item->meta->get('set_discount'))
            {{ $item->meta->get('discount') }}
            <span><strike>{{ $item->price }}</strike></span>
        @else
            {{ $item->price }}
        @endif
        <button class="make-payment" type="button" data-id="{{ $item->id }}">pay</button>
    </li>
    @endforeach
</ul>

{{-- session()->get('payment_status') --}}

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(function() {
        $('#pricing_list').on('click', 'button.make-payment', function (e) { // activate user
            e.preventDefault();

            const btn = $(e.target);
            const id = btn.attr('data-id');

            console.log();
                
            let paymentUrl = `{{ route('plans.payment', ':id') }}`;
            paymentUrl = paymentUrl.replace(':id', id);

            $.ajax({
                type: 'POST',
                url: paymentUrl,
                data: {
                    "_token": `{{ csrf_token() }}`,
                    'preferences': `{{ $preferences }}`
                },
                success: function(response) {
                    if (response.hasOwnProperty('status') && response.status == 'success') {
                        window.location.replace(response.data.link);
                        // Swal.fire('Activated!', 'Video has been activated.', 'success');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log( XMLHttpRequest.responseJSON.errors);
                    console.log(XMLHttpRequest.status)
                    console.log(XMLHttpRequest.statusText)
                    console.log(errorThrown)
            
                    // display toast alert
                    // toastr.clear();
                    // toastr.options = {
                    //     "timeOut": "7000",
                    // }
                    // NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                }
            });
            
        });
    });
</script>