<form method="POST" action="{{ route('task.save') }}">
    @csrf

    <!-- Title -->
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required autofocus autocomplete="title" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- Description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description', $task->description)" autocomplete="description" />
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <!-- Due Date -->
    <div class="mt-4">
        <x-input-label for="due_date" :value="__('Due Date')" />

        <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" :value="old('due_date') ?? $task->due_date" required autocomplete="due_date" />

        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="status" :value="__('Status')" />

        <x-select id="status" class="block mt-1 w-full" name="status">
            <option value="" >{{ __('- Please Select Status -') }}</option>

            <option {{$task->status === 'pending' ? 'selected' : ''}} value="pending">Pending</option>
            <option {{$task->status === 'completed' ? 'selected' : ''}} value="completed">Completed</option>
        </x-select>

        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
    <div class="flex items-center justify-end mt-4">
        @if(Route::current()->getName() === 'task.add')
            <x-primary-button class="ml-4">
                {{ __('Create Task') }}
            </x-primary-button>
        @elseif(Route::current()->getName() === 'task.edit')
            <x-text-input id="task_id" type="hidden" name="task_id" value="{{$task->id}}" />

            <x-primary-button class="ml-4">
                {{ __('Update Task') }}
            </x-primary-button>
        @endif

    </div>
</form>
