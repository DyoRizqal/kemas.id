<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') | {{ appName() }} </title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'DyoRizqal')">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">
    @yield('meta')

    @stack('before-styles')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <livewire:styles />
    @stack('statis-css')
    @if ($announcements->count())
        <style>
            #app {
                flex: 1;
                margin-top: 5rem;
            }
        </style>
    @else
        <style>
            #app {
                flex: 1;
                margin-top: 3.5rem;
            }
        </style>
    @endif
    @stack('after-styles')
</head>

<body>
    @include('includes.partials.logged-in-as')
    {{-- @include('includes.partials.announcements') --}}

    @include('frontend.includes.nav')
    <div id="app">
        @include('includes.partials.messages')

        <main>
            @yield('content')
            @auth
                <div id="floatingButton">
                    <button><i class="fas fa-envelope-open"></i></button>
                </div>

                <div id="suggestionBox">
                    <span class="close-btn" onclick="toggleSuggestionBox()">&times;</span>
                    <textarea id="suggestionText" placeholder="Tulis pesan Anda di sini..." name="message"></textarea>
                    <button onclick="submitSuggestion()">Kirim Pesan</button>
                </div>
            @endauth
        </main>
    </div><!--app-->
    @include('frontend.includes.footer')

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script>
        var storeMessageUrl = "{{ route('home.store_message') }}";
        $(document).ready(function() {
            $('textarea[class^="area"]').each(function() {
                CKEDITOR.replace(this);
            });
        });
        window.onscroll = function() {
            makeSticky()
        };

        window.onscroll = function() {
            makeSticky();
        };

        var navbar = document.querySelector('.custom-navbar');
        var stickyOffset = 50;

        function makeSticky() {
            if (window.pageYOffset >= stickyOffset) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        }
        document.getElementById("floatingButton").onclick = function() {
            toggleSuggestionBox();
        };

        function toggleSuggestionBox() {
            var suggestionBox = document.getElementById("suggestionBox");
            suggestionBox.style.display = suggestionBox.style.display === "none" ? "block" : "none";
        }

        function submitSuggestion() {
            var message = $('#suggestionText').val();

            $.ajax({
                url: storeMessageUrl,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    message: message
                },
                success: function(response) {
                    Swal.fire(
                        'Berhasil!',
                        'Pesan berhasil terkirim ke Admin',
                        'success'
                    );

                    $('#suggestionText').val('');
                },
                error: function(response) {
                    console.log(response);
                    Swal.fire(
                        'Error',
                        'Terjadi kesalahan saat mengirim pesan',
                        'error'
                    );
                }
            });
        }
    </script>
    @stack('custom-scripts')
    <livewire:scripts />
    @stack('after-scripts')
</body>

</html>
