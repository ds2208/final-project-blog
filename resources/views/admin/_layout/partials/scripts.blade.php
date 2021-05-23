<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{url('themes/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{url('/themes/admin/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
<!-- Valitation form -->
<script src="{{url('themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- select2 -->
<script src="{{url('/themes/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<!-- Toastr -->
<script src="{{url('themes/admin/plugins/toastr/toastr.min.js')}}"></script>
<script type="text/javascript">
systemMessage = "{{session()->pull('system_message')}}";
if (systemMessage !== "") {
    toastr.success(systemMessage);
}
systemError = "{{session()->pull('system_error')}}";
if (systemError !== "") {
    toastr.error(systemError);
}
</script>
<!-- AdminLTE App -->
<script src="{{url('themes/admin/dist/js/adminlte.min.js')}}"></script>

@stack('script_tags')