</div>

</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
<strong>Copyright &copy; 2014-2021 <a href="https://fudex.com.sa">New waves</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">

</div>
</footer>




<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('dist/js/select2.full.min.js')}}"></script>
<script src='{{asset('generalAssets/'.app()->getLocale().'/paths.js')}}'></script>
<script src='{{asset('generalAssets/general.js')}}'></script>
<script src='{{asset('generalAssets/ajaxGeneral.js')}}'></script>
<script src='{{asset('front/jquery-confirm/js/jquery-confirm.js')}}'></script>
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        @if (session('success_message'))
            toastr.success('{{session('success_message')}}');
        @elseif (session('error_message'))
            toastr.error('{{session('error_message')}}');
        @endif

        $('[type=submit]').click(function(){
            $(this).hide('fast');
        });

    });
</script>
<script defer src="https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js"></script>

@stack('scripts')
@livewireScripts()
<div
 id="data-div"
 data-confirm-msg='@lang('general.are_you_sure')'
 data-are-you-sure='@lang('general.are_you_sure')'
 data-delete='@lang('general.remove')'
 data-cancel='@lang('general.cancel')'
 ></div>
</body>
</html>
