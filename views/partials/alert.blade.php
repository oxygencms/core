<div class="alert alert-{{ $type }} alert-dismissible" role="alert">
    <button type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
    >
        <span aria-hidden="true">&times;</span>
    </button>

    {{ $slot }}
</div>

@push('js')
    <script>
        $('.alert').delay(5000).fadeOut(300);
    </script>
@endpush