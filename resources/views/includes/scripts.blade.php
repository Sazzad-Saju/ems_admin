<!-- jQuery -->
<script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<!-- jquery-validation -->
<script src="{{asset('asset/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<!-- DataTables -->
<script src="{{asset('asset/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

{{--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>--}}
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<!-- Sweetalert2 -->
<script src="{{asset('asset/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- FullCalender -->
<script src="{{asset('asset/plugins/fullcalendar/lib/main.js')}}"></script>
<script src="{{asset('asset/plugins/fullcalendar/lib/main.js')}}"></script>
{{--<script src="{{asset('asset/plugins/fullcalendar/lib/theme-chooser.js')}}"></script>--}}
{{--<script src='js/theme-chooser.js'></script>--}}

<!-- Moments -->
<script src="{{asset('asset/plugins/moment/moment.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- Daterange picker -->
<script src="{{asset('asset/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('asset/js/adminlte.min.js')}}"></script>
<script src="{{asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<script>

    $(function () {


        const Toast = Swal.mixin({
            toast: true,
            position: "{{settings('toast_position')}}",
            showConfirmButton: false,
            timer: 5000
        });

        @if(Session::has('success'))
        Toast.fire({
            icon: 'success',
            title: `{{Session::get('success')}}`
        })
        @elseif(Session::has('warning'))
        Toast.fire({
            icon: 'warning',
            title: `{{Session::get('warning')}}`
        })
        @elseif(Session::has('error'))
        Toast.fire({
            icon: 'error',
            title: `{{Session::get('error')}}`
        })
        @elseif(Session::has('info'))
        Toast.fire({
            icon: 'info',
            title: `{{Session::get('info')}}`
        })
        @endif

        // / Side navbar active start /
        // add active class and stay opened when selected
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.nav-sidebar a').filter(function () {
            return this.href == url;
        }).addClass('active');

        // for treeview
        $('ul.nav-treeview a').filter(function () {
            return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
        // / End side navbar active /

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize DateRangePicker for single date Elements
        let date_format = @json(settings('date_format'));
        $('.singleDateRange').prop('readonly',true)
        $('.singleDateRange').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,

            locale: {
                format: date_format
            }
        })
        $('.singleDateRange').val('')
        $('.singleDateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


        //Initialize DateRangePicker for Time selection
        let time_format = @json(settings('time_format'));
        let isTime24hFormat = @json(settings('time_format')) == 'H:mm'
        $('.singleTimePicker').prop('readonly',true)
        $('.singleTimePicker').daterangepicker({
            timePicker : true,
            singleDatePicker:true,
            timePicker24Hour : isTime24hFormat,
            locale : {
                format : time_format
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
        $('.singleTimePicker').val('')
        $('.singleTimePicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


    });


</script>


@stack('js')

