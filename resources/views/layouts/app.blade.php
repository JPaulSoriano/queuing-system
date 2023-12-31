<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function updateQueueLists() {
            $.ajax({
                url: '{{ route('queues.list') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Update the queue lists on the index and customer views
                    updateIndexView(data.queues);
                    updateCustomerView(data.queues);

                    // Enable the "Get Queue" button and hide the loading indicator
                    $('#get-queue-button').prop('disabled', false);
                    $('#loading-indicator').hide();
                }
            });
        }
        function updateNowServing() {
            $.ajax({
                url: '{{ route('current-serving') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var registrarListHtml = '<h1>Now Serving:</h1>';

                    $.each(data.registrars, function(index, registrar) {
                        if (registrar.currentQueue) {
                            registrarListHtml += '<h1>Queue #' + registrar.currentQueue.number + ' on ' + registrar.name + '</h1>';
                        } else {
                            registrarListHtml += '<h1>No queue is currently being served on ' + registrar.name + '</h1>';
                        }
                    });

                    $('#now-serving').html(registrarListHtml);
                }
            });
        }
        // Function to update the queue list on the index view
        function updateIndexView(queues) {
            var queueListHtml = '<h2>Queue Lists:</h2><ul>';
            $.each(queues, function(index, queue) {
                queueListHtml += '<li>Queue #' + queue.number + '</li>';
            });
            queueListHtml += '</ul>';
            $('#queue-list').html(queueListHtml);
        }
        // Function to update the queue list on the customer view
        function updateCustomerView(queues) {
            var queueListHtml = '<h2>Queue Lists:</h2><ul>';
            $.each(queues, function(index, queue) {
                queueListHtml += '<li>Queue #' + queue.number + '</li>';
            });
            queueListHtml += '</ul>';
            $('#customer-queue-list').html(queueListHtml);
        }

        $('#get-queue-form').submit(function(event) {
            event.preventDefault();
            // Disable the "Get Queue" button and show the loading indicator
            $('#get-queue-button').prop('disabled', true);
            $('#loading-indicator').show();

            $.ajax({
                url: '{{ route('getQueue') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function() {
                    // Queue request was successful
                    // No need to do anything here, as updates will be handled by updateQueueLists()
                },
                error: function() {
                    // Handle error if the queue request fails
                    // You may want to display an error message to the user
                }
            });
        });

        // Function to trigger text-to-speech
        function speakNowServing(text) {
            var msg = new SpeechSynthesisUtterance();
            msg.text = text;
            window.speechSynthesis.speak(msg);
        }
        // Event handler for the text-to-speech button
        $('#text-to-speech-button').on('click', function() {
            var nowServingInfo = $('#now-serving-info').val();
            if (nowServingInfo) {
                speakNowServing(nowServingInfo);
            }
        });

        // Poll for updates every 5 seconds (adjust the interval as needed)
        setInterval(updateQueueLists, 2500);
        setInterval(updateNowServing, 2500);
        // Initial update on page load
        updateQueueLists();
        updateNowServing();
    });
    </script>
</body>
</html>
