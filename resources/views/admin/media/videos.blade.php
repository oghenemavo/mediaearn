@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/tinymce.css?ver=2.8.0') }}">
    <style>
        img.cover-image {
            width: 150px;
            height:150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage Videos</h4>
                    <div class="nk-block-des">
                        <p>Add and manage videos.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#create_video_modal"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="video_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Title</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Category</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Length</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Earnable <span class="text-success">(S)</span></span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Earnable <span class="text-danger">(NS)</span></span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Earned After</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Created at</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
</div>


<!-- @Video Create Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="create_video_modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add a Video</h5>
                
                <form id="create_video" action="{{ route('admin.media.create.video') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="title">Title</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg  @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" autofocus>
                            
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categories</label>
                        <div class="form-control-wrap">
                            <select data-ui="lg" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option>Choose a Category</option>    
                                @foreach($categories as $data)
                                    <option value="{{ $data->id }}">{{ ucfirst($data->category) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-error="category_id" class="error"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Video Type</label>
                        <div class="form-control-wrap">
                            <select data-ui="lg" id="video_type" name="video_type" class="form-select @error('video_type') is-invalid @enderror">
                                <option>Choose a Video Type</option>
                                @foreach($video_types as $data)
                                    <option value="{{ $data->value }}">{{ ucfirst($data->value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-error="video_type" class="error"></div>
                    </div>

                    <div id="upload_video_div" class="form-group">
                        <label class="form-label" for="video_file">Video File</label>
                        <div class="form-control-wrap">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('video_file') is-invalid @enderror" id="video_file" name="video_file">
                                <label class="custom-file-label" for="video_file">Choose file</label>
                                @error('video_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div data-error="video_file" class="error"></div>
                            </div>
                        </div>
                    </div>

                    <div id="youtube_video_div" class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="video_id">Youtube Video ID</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">https://youtube.com/watch?v=</span>
                                </div>
                                <input type="text" class="form-control form-control-lg  @error('video_id') is-invalid @enderror"
                                id="video_id" name="video_id" value="{{ old('video_id') }}" placeholder="e.g. l7fXRnM121Q">
                                
                                @error('video_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="length">Video Length</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg @error('length') is-invalid @enderror"
                                id="length" name="length" value="{{ old('length') }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">seconds</span>
                                </div>
                                @error('length')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-note" data-note="length"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="description">Video Description</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg  @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                           
                           
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="charges">Vendor Charges</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">&#8358;</span>
                                </div>
                                <input type="number" class="form-control form-control-lg  @error('charges') is-invalid @enderror"
                                id="charges" name="charges" value="{{ old('charges') }}" min="100" step="0.01" max="1000000000">
                            
                                @error('charges')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="earnable">Earnable (Subscribers)</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">&#8358;</span>
                                </div>
                                <input type="number" class="form-control form-control-lg  @error('earnable') is-invalid @enderror"
                                id="earnable" name="earnable" value="{{ old('earnable') }}" min="1" step="0.01">
                                
                                @error('earnable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-note">Earnable Value for Subscribed Users</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="earnable">Earnable (Non Subscribers)</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">&#8358;</span>
                                </div>
                                <input type="number" class="form-control form-control-lg  @error('earnable_ns') is-invalid @enderror"
                                id="earnable_ns" name="earnable_ns" value="{{ old('earnable_ns') }}" min="1" step="0.01">
                                
                                @error('earnable_ns')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-note">Earnable Value for <b>Non</b> Subscribed Users</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="earned_after">Earn After Watching for:</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg @error('earned_after') is-invalid @enderror"
                                id="earned_after" name="earned_after" value="0" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">seconds</span>
                                </div>
                                @error('earned_after')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-note" data-note="earned_after"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cover">Cover Image</label>
                        <div class="form-control-wrap">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('cover') is-invalid @enderror" id="cover" name="cover">
                                <label class="custom-file-label" for="cover">Choose file</label>
                                @error('cover')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div data-error="cover" class="error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-4">
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-lg btn-primary">Create Video</button>
                                </li>
                                <li>
                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!--Video Create .modal -->
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/libs/editors/tinymce.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/editors.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script>
        $(function() {
            $('#earned_after').on('input change keypress', function() {
                if ($(this).attr('max') > 0) {
                    $('div[data-note="earned_after"]').text(hhmmss($(this).val()))
                }
            });
            
            $('#video_id').on('input', function() {
                const video_id = $(this).val();
                if (video_id.length == 11) {
                    fetchVideoInfo(`https://www.googleapis.com/youtube/v3/videos?id=${video_id}&part=contentDetails&key={{ env('YOUTUBE_KEY') }}`)
                    .then(data => {
                        $('#length').val('');
                        $('#earned_after').val('').attr('readonly', true).removeAttr('max');
                        $('div[data-note="length"]').text('');

                        if (data.pageInfo.totalResults == '1') { // returned a result
                            const iso8601 = data.items[0].contentDetails.duration;
                            const seconds = moment.duration(iso8601).asSeconds();
                            $('#length').val(seconds);
                            $('#earned_after').attr('max', seconds-1).attr('readonly', false);
                            $('div[data-note="length"]').text(hhmmss(seconds));
                            $('#create_video').find('button[type="submit"]').attr('disabled', false);
                        } else {
                            toastr.clear();
                            NioApp.Toast('The Youtube ID is wrong.', 'warning', {
                                position: 'top-right',
                                ui: 'is-dark',
                            });
                            $('#create_video').find('button[type="submit"]').attr('disabled', true);
                        }
                    })
                    .catch(error => {
                        console.log()
                        error.message; // 'An error has occurred: 404'
                    });
                }
            });

            async function fetchVideoInfo(url) {
                const response = await fetch(url);
                if (!response.ok) {
                    const message = `An error has occured: ${response.status}`;
                    throw new Error(message);
                }
                return await response.json();
            }

            NioApp.DataTable($('#video_table'), {
                ajax: {
                    url: `{{ route('get.videos') }}`,
                    dataSrc: 'videos'
                },
                createdRow: function( row, data, dataIndex ) {
                    $(row).addClass( 'nk-tb-item' );
                },
                buttons: [
                    {
                        text: 'Reload',
                        className: 'btn reload px-2 btn-primary btn-sm',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                        },
                    },
                ],
                columns: [
                    { data: 'title', className: 'nk-tb-col tb-col-md' },
                    { data : 'category', className : 'nk-tb-col tb-col-md' },
                    { data : 'length', className : 'nk-tb-col tb-col-md' },
                    { data : 'earnable', className : 'nk-tb-col tb-col-md' },
                    { data : 'earnable_ns', className : 'nk-tb-col tb-col-md' },
                    { data : 'earned_after', className : 'nk-tb-col tb-col-md' },
                    { 
                        data : 'status', className : 'nk-tb-col tb-col-md',
                        render: function(data) {
                            var activity = '';
                            if (data == '0') {
                                activity += `<span class="badge badge-dim badge-pill badge-gray">Inactive</span>`;
                            } else {
                                activity += `<span class="badge badge-dim badge-pill badge-success">Active</span>`;
                            }
                            return activity;
                        } 
                    },
                    { 
                        data        : 'created_at', className   : 'nk-tb-col tb-col-lg',
                        render      : function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        } 
                    },
                ],
                columnDefs: [
                    {
                        targets   : 8,
                        className : 'nk-tb-col nk-tb-col-tools',
                        data      : null,
                        render    : function (data, type, full, meta) {
                            let video_status = '';
                            if (data.status == '1') {
                                video_status += `<li><a href="#" class="block-video">
                                    <em class="icon ni ni-na text-danger"></em>
                                    <span class="text-danger">Block Video</span>
                                </a></li>`;
                            } else {
                                video_status = `<li><a href="#" class="activate-video">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="text-success">Activate Video</span>
                                </a></li>`;
                            }
                            return `
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" data-toggle="modal" data-target="#view_video_${data.id}"><em class="icon ni ni-eye"></em><span>View Video</span></a></li>
                                                    <li><a href="{{ route('admin.media.view.video') }}/${data.id}"><em class="icon ni ni-edit"></em><span>Edit Video</span></a></li>
                                                    <li class="divider"></li>
                                                    ${video_status}
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <!-- @View Video Modal-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="view_video_${data.id}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                            <div class="modal-body modal-body-lg">
                                                <h5 class="modal-title">User</h5>
                                                
                                                <dl class="row pt-3">
                                                    <dt class="col-sm-3">Title</dt>
                                                    <dd class="col-sm-9">${data.title}</dd>

                                                    <dt class="col-sm-3 text-truncate">Video Description</dt>
                                                    <dd class="col-sm-9">${data.description}</dd>
    
                                                    <dt class="col-sm-3">Video Length</dt>
                                                    <dd class="col-sm-9">${hhmmss(data.length)}</dd>
    
                                                    <dt class="col-sm-3">Vendor Charges</dt>
                                                    <dd class="col-sm-9">&#8358;${data.charges}</dd>
    
                                                    <dt class="col-sm-3">Earnable</dt>
                                                    <dd class="col-sm-9">&#8358;${data.earnable}</dd>
    
                                                    <dt class="col-sm-3">Earned After</dt>
                                                    <dd class="col-sm-9">${hhmmss(data.earned_after)}</dd>
    
                                                    <dt class="col-sm-3">Cover</dt>
                                                    <dd class="col-sm-9">
                                                        <img class="cover-image" src="${data.cover}" alt="${data.slug}">
                                                    </dd>
    
                                                    <dt class="col-sm-3">Video</dt>
                                                    <dd class="col-sm-9">
                                                        <div class="ratio ratio-16x9">
                                                            <iframe src="${data.video_url}" title="${data.slug}" allowfullscreen sandbox></iframe>
                                                        </div>
                                                    </dd>
    
                                                    <dt class="col-sm-3">Status</dt>
                                                    <dd class="col-sm-9">
                                                        ${data.status == '1' ? '<span class="badge badge-dot badge-success">Active</span>' : '<span class="badge badge-dot badge-danger">Inactive</span>'}
                                                    </dd>
                                                </dl>
                                            
                                            </div><!-- .modal-body -->
                                        </div><!-- .modal-content -->
                                    </div><!-- .modal-dialog -->
                                </div>
                                <!--View Video .modal -->
                            `;
                        }
                    }
                ],
            });

            $('#video_table tbody').on('click', 'a.activate-video', function (e) { // activate user
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#video_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data
                
                let unblockUrl = `{{ route('admin.media.unblock.video', ':id') }}`;
                unblockUrl = unblockUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Users would have access to this video!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate video!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: unblockUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`, 
                                video_id: data.id,
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    Swal.fire('Activated!', 'Video has been activated.', 'success');
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log( XMLHttpRequest.responseJSON.errors);
                                console.log(XMLHttpRequest.status)
                                console.log(XMLHttpRequest.statusText)
                                console.log(errorThrown)
                        
                                // display toast alert
                                toastr.clear();
                                toastr.options = {
                                    "timeOut": "7000",
                                }
                                NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                            }
                        });
                        
                    }
                });
            });
    
            $('#video_table tbody').on('click', 'a.block-video', function (e) { // add product to cart
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#video_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                let blockUrl = `{{ route('admin.media.block.video', ':id') }}`;
                blockUrl = blockUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "User won't have access to this content!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Block Video!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: blockUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`, 
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    Swal.fire('Blocked!', 'Video has been blocked.', 'success');
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log( XMLHttpRequest.responseJSON.errors);
                                console.log(XMLHttpRequest.status)
                                console.log(XMLHttpRequest.statusText)
                                console.log(errorThrown)
                        
                                // display toast alert
                                toastr.clear();
                                toastr.options = {
                                    "timeOut": "7000",
                                }
                                NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                            }
                        });
                        
                    }
                });
            });

            var myVideos = [];

            window.URL = window.URL || window.webkitURL;

            document.getElementById('video_file').onchange = setFileInfo;

            function setFileInfo() {
                var files = this.files;
                myVideos.push(files[0]);
                var video = document.createElement('video');
                video.preload = 'metadata';

                video.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(video.src);
                    var duration = video.duration;
                    myVideos[myVideos.length - 1].duration = duration;
                    updateInfos();
                }

                video.src = URL.createObjectURL(files[0]);;
            }

            function updateInfos() {
                // infos.textContent = "";
                // console.log(myVideos);
                var infos = document.getElementById('infos');

                $('#length').val('');
                $('#earned_after').val('').attr('readonly', true).removeAttr('max');
                $('div[data-note="length"]').text('');

                for (var i = 0; i < myVideos.length; i++) {
                    // infos.textContent += myVideos[i].name + " duration: " + myVideos[i].duration + '\n';
                    // console.log(myVideos[i].duration);
                    // $('#length').val(myVideos[i].duration);

                    $('#length').val(myVideos[i].duration);
                    $('#earned_after').attr('max', myVideos[i].duration-1).attr('readonly', false);
                    $('div[data-note="length"]').text(hhmmss(myVideos[i].duration));
                }
            }

            $.validator.setDefaults({
                errorElement: "div",
                errorClass: 'invalid-feedback',
                highlight: function highlight(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function unhighlight(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function errorPlacement(error, element) {
                    error.insertAfter(element);
                }
            });

            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'File size must be less than {0} MB');

            $('#youtube_video_div').hide();
            $('#upload_video_div').hide();

            $('#video_type').change(function() {
                //Use $option (with the "$") to see that the variable is a jQuery object
                var $option = $(this).find('option:selected');
                
                var type = $option.val();//to get content of "value" attrib
                if (type == 'upload') {
                    $('#upload_video_div').show();
                    $('#youtube_video_div').hide();
                } else {
                    $('#youtube_video_div').show();
                    $('#upload_video_div').hide();
                }
            });

            $('#create_video').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 4,
                    },
                    category_id: {
                        required: true,
                    },
                    video_type: {
                        required: true,
                    },
                    video_id: {
                        required: function() {
                            if ($('#video_type').find('option:selected').val() == "youtube")
                                return true;
                            else
                                return false;
                        },
                        minlength: 11,
                        maxlength: 11,
                    },
                    video_file: {
                        required: function() {
                            if ($('#video_type').find('option:selected').val() == "upload")
                                return true;
                            else
                                return false;
                        },
                        accept: "video/*",
                        filesize: 100,
                    },
                    length: {
                        required: true,
                    },
                    description: {
                        required: true,
                        minlength: 20,
                    },
                    charges: {
                        required: true,
                        min: 100,
                        max: 1000000000,
                    },
                    earnable: {
                        required: true,
                    },
                    earnable_ns: {
                        required: true,
                    },
                    earned_after: {
                        required: true,
                    },
                    cover: {
                        required: true,
                        accept: "image/*",
                        filesize: 10,
                    }
                },
                messages: {
                    category_id: "Select a Video Category.",
                    body: "Enter Describe your Video here in details",
                    cover: {
                        accept: 'Only Images file formats are accepted',
                    }
                },
            });

            function pad(num) {
                return ("0"+num).slice(-2);
            }
            function hhmmss(secs) {
                var minutes = Math.floor(secs / 60);
                secs = secs%60;
                var hours = Math.floor(minutes/60)
                minutes = minutes%60;
                return `${pad(hours)}:${pad(minutes)}:${pad(secs)}`;
            // return pad(hours)+":"+pad(minutes)+":"+pad(secs); for old browsers
            }
        });
    </script>
@endpush