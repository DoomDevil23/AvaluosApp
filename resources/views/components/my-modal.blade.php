@props([
    'id' => '', // Unique modal ID
    'title' => '', // Modal title
    'formId' => '', // ID for the form
    'inputs' => [], // Array of inputs (name, label, type, etc.)
    'footerButtons' => [] // Array of footer buttons (label, type, classes, etc.)
])

<div class="modal" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label">
    <div class="modal-dialog">
        <form id="{{ $formId }}">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" aria-label="Cerrar"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    @foreach ($inputs as $input)
                        <div class="mb-3">
                            <label for="{{ $input['id'] }}" class="form-label">{{ $input['label'] }}</label>
                            <input 
                                type="{{ $input['type'] }}" 
                                class="form-control" 
                                id="{{ $input['id'] }}" 
                                name="{{ $input['name'] }}" 
                                {{ $input['required'] ? 'required' : '' }}
                            >
                        </div>
                    @endforeach
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    @foreach ($footerButtons as $button)
                        <button 
                            type="{{ $button['type'] }}" 
                            class="{{ $button['classes'] }}"
                        >
                            {{ $button['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>