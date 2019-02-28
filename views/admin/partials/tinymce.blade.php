@push('js')
    <script src='{{ asset('tinymce/tinymce.min.js') }}'></script>
    <script>
        tinymce.init({
            selector: '{{ $selector }}',
            plugins: ['code', 'link', 'image'],
            relative_urls : false,
            remove_script_host : true,
            @if($model)
            image_list: '{{ route('admin.media.list', ['mediable_type' => get_class($model), 'mediable_id' => $model->id]) }}'.replace(/&amp;/g, '&'),
            @endif
            image_advtab: true,
            image_dimensions: false,
            image_class_list: [
                {title: 'None', value: ''},
                {title: 'Responsive', value: 'img-responsive'},
            ],
        });
    </script>
@endpush