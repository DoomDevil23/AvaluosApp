@props([
    'type' => 'success', // Type of alert (e.g., success, error, etc.)
    'message' => '',     // The alert message
])

@if($message)
    <div class="alert-{{ $type }} p-4 rounded-lg shadow-md bg-green-100 text-green-700 relative">
        {{ $message }}
    </div>
@endif