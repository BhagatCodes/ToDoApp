<div class="modal" id="add-task-modal" aria-hidden="true">
    <div class="modal-overlay" aria-hidden="true"></div>

    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="addTaskTitle">
        <div class="modal-header">
            <h3 id="addTaskTitle" class="text-lg font-semibold">Add Task</h3>
            <button type="button" class="btn btn-ghost" aria-label="Close">✕</button>
        </div>

        <form id="task-form" action="/tasks" method="post" class="modal-content">
            @csrf
            <input type="hidden" name="task_id" id="task-id" value="">

            <div class="modal-body space-y-3">
                <div>
                    <label class="block text-sm font-medium">Category</label>
                    <select name="category_id" class="form-input w-full">
                        @if($hasCategories)
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Title</label>
                    <input name="task_title" type="text" class="form-input w-full" placeholder="Task title" />
                    @error('task_title')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <textarea name="task_description" rows="3" class="form-input w-full" placeholder="Optional description"></textarea>
                    @error('task_description')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium">Start</label>
                        <input name="task_start" type="datetime-local" class="form-input w-full" />
                        @error('task_start')
                        <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Working hours</label>
                        <input name="working_hours" type="number" min="0" class="form-input w-full" />
                        @error('working_hours')
                        <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost">Cancel</button>
                <button type="submit" id="task-submit-btn" class="btn btn-primary">Create Task</button>
            </div>
        </form>
    </div>
</div>
