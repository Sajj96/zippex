@include('partials._header', ['title' => $title ?? ''])


<body class="theme-blue">
    @include('partials._navigation')

    <!-- Main Content -->
    <section class="content">
        <div class="">
            @yield('breadcrumb')
            @include('partials._notification')

            @yield('workspace')
        </div>
    </section>

    <!-- Jquery Core Js --> 
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
    <script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>

    @yield('scripts')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
</body>

</html>