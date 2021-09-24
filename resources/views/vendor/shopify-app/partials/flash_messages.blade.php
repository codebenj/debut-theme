<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        @if (session()->has('status'))
            customToastMessage("{{ session('status') }}");
            {{--
            var toastNotice = Toast.create(ShopifyApp, {
                message: "{{ session('status') }}",
                duration: 3000,
            });
            toastNotice.dispatch(Toast.Action.SHOW);
            --}}
        @endif

        @if (session()->has('error'))
            customToastMessage("{{ session('error') }}", false);
            {{--
            var toastNotice = Toast.create(ShopifyApp, {
                message: "{{ session('error') }}",
                duration: 3000,
                isError: true,
            });
            toastNotice.dispatch(Toast.Action.SHOW);
            --}}
        @endif
    });
</script>
