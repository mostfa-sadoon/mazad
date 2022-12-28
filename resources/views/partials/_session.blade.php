@php
    $lang = app()->getLocale();
    $layout = 'topRight';
    if ($lang == 'ar') {
        $layout = 'topLeft';
    }
@endphp
@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: '{{$layout}}',
            text: "{{ session('success') }}",
            timeout: 4000,
            killer: true
        }).show();
    </script>

@endif

@if (session('info'))

    <script>
        new Noty({
            type: 'info',
            layout: '{{$layout}}',
            text: "{{ session('info') }}",
            timeout: 4000,
            killer: true
        }).show();
    </script>

@endif

@if (session('warning'))

    <script>
        new Noty({
            type: 'warning',
            layout: '{{$layout}}',
            text: "{{ session('warning') }}",
            timeout: 5000,
            killer: true
        }).show();
    </script>

@endif
