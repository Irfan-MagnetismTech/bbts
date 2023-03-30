<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/modernizr.js') }}"></script>
<script src="{{ asset('js/css-scrollbars.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/SmoothScroll.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/custom-function.js') }}"></script>
<script src="{{ asset('js/pcoded.min.js') }}"></script>
<script src="{{ asset('js/vertical-layout.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }} "></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
@yield('script')

<script>
    $(document).ready(function() {
        $(".delete").click(function() {
            if (!confirm("Do you want to delete?")) {
                return false;
            }
        });

        $(".approve").click(function() {
            if (!confirm("Are you sure to approve / accept?")) {
                return false;
            }
        });
        
    });

    $(document).ready(function() {
        $('#dataTable').DataTable({
            stateSave: true
        });
    });
</script>

<script>

    let userId = '{{ auth()->user()->id }}';
    Echo.private(`App.Models.User.${userId}`).listen('.ticket-movement-event', (e) => {
        // let data = JSON.parse(e.data.message);

        // console.log('Received myCustomEvent:', e);
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: e.message,
            showConfirmButton: false,
            timer: 5000,
            toast: true,
            timerProgressBar: true,
            showCloseButton: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

    }).error((error) => {
        console.error(error);
    });

</script>