



        <!-- start footer -->
        <x-footer/>

        <!-- sub-footer -->
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>@lang('site.all_rights_are_reserved_developped_by') <a href="http://arnewwaves.net" class="sub-foot">New Waves</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- start scripts -->


        <script src="{{asset("front/assets")}}/js/jquery.js"></script>
        <script src="{{asset("front/assets")}}/js/popper.min.js"></script>
        <script src="{{asset("front/assets")}}/js/code.js"></script>
        <script src="{{asset("front/assets")}}/js/general.js"></script>



        @livewireScripts
        @stack('scripts')
    </body>

    <!-- end of body -->
</html>
