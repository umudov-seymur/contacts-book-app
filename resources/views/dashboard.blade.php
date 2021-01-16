<x-app-layout>
    <div id="app"></div>
    <script>
        window.user_data = @json(auth()->user())
    </script>
</x-app-layout>
