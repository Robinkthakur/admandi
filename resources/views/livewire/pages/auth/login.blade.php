<div>
    <livewire:auth.login redirect="login" />
     {{-- jquery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#loginModal').modal('show');
        });
    </script>
</div>