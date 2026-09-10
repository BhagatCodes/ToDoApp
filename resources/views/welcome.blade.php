@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h2 style="margin:0" class="text-2xl font-semibold">Tasks</h2>
        </div>

        {{-- <form id="add-task-form" class="mt-3" onsubmit="return false;">
            <div class="flex gap-2 items-center">
                <input id="task-title" placeholder="Task title" class="form-input flex-1 min-w-0" />
                <input id="task-due" type="date" class="form-input w-36 flex-none" />
                <button id="add-task-btn" class="btn btn-primary flex-none">Add Task</button>
            </div>
        </form> --}}

        <div class="tasks mt-4 flex flex-col gap-5" id="tasks-list">
            @if($tasks->isEmpty())
                <div class="muted">No tasks yet.</div>
            @else
                @foreach ($tasks as $task)
                    <div class="bg-white shadow-sm p-4 rounded-sm flex justify-between items-center task-item" data-category="{{ $task->category_id }}">
                        <div>
                            <h3 class="text-lg font-medium text-secondary">{{ $task->task_title }}</h3>
                            <p class="text-light text-md font-normal">{{ $task->task_description }}</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <p class="text-sm px-2 py-1 text-center text-primary border border-primary rounded-sm">{{ optional($task->category)->name ?? '—' }}</p>
                            <div class="flex items-center gap-3 ">
                                <button type="button"
                                    class="edit-task-btn open-task-modal-btn h-8 w-8 rounded-full text-primary border border-primary flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white"
                                    data-task-id="{{ $task->id }}"
                                    data-task-title="{{ $task->task_title }}"
                                    data-task-description="{{ $task->task_description ?? '' }}"
                                    data-task-start="{{ $task->task_start ?? '' }}"
                                    data-working-hours="{{ $task->working_hours ?? 0 }}"
                                    data-category-id="{{ $task->category_id }}"
                                    aria-label="Edit task">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                </button>
                                <div class="h-8 w-8 rounded-full text-primary border border-primary flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                </div>   
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button id="add-task-btn" class="open-task-modal-btn btn btn-primary flex-none mt-3">Add Task</button>
    </div>

    {{-- @push('scripts')
    <script>
        // UI glue: categories sidebar and tasks area
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const openBtn = document.querySelector('#add-task-btn');
                const modal = document.getElementById('add-task-modal');
                if (!modal) return;
                const overlay = modal.querySelector('.modal-overlay');
                const closeButtons = modal.querySelectorAll('button[aria-label="Close"], .modal-footer .btn-ghost');

                function openModal() {
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                    const first = modal.querySelector('input,select,textarea,button');
                    if (first) first.focus();
                }

                function closeModal() {
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }

                openBtn?.addEventListener('click', (e) => { e.preventDefault(); openModal(); });
                overlay?.addEventListener('click', () => closeModal());
                closeButtons.forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); closeModal(); }));
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
            });
        </script>
                if(tasks.length===0){ tasksListEl.innerHTML = '<div class="muted">No tasks yet.</div>'; return }
                tasks.forEach(t=>{
                    const el = document.createElement('div'); el.className='task';
                    el.innerHTML = `<div><div style="font-weight:600">${escapeHtml(t.title)}</div><div class="muted">${t.category || '—'} · ${t.due||''}</div></div><div><button data-id="${t.id}" style="background:none;border:0;cursor:pointer;color:var(--muted)">Done</button></div>`;
                    el.querySelector('button').onclick = ()=>{ delete state.tasks[t.id]; save(); render(); };
                    tasksListEl.appendChild(el);
                })
            }

            function render(){
                renderCategories();
                renderTasks();
                activeLabel.textContent = activeCategory||'All';
            }

            function addCategory(name){
                name = name && name.trim();
                if(!name) return;
                if(state.categories.includes(name)) return;
                state.categories.push(name);
                save();
                categoryInput.value='';
                render();
            }

            function removeCategory(name){
                state.categories = state.categories.filter(c=>c!==name);
                // remove tasks in that category
                for(const id in state.tasks) if(state.tasks[id].category===name) delete state.tasks[id];
                if(activeCategory===name) activeCategory=null;
                save(); render();
            }

            function addTask(){
                const title = taskTitle.value && taskTitle.value.trim();
                if(!title) return;
                const id = Date.now().toString(36)+Math.random().toString(36).slice(2,6);
                const t = {id,title,category:activeCategory, due: taskDue.value||null, created: Date.now()};
                state.tasks[id]=t; save(); taskTitle.value=''; taskDue.value=''; render();
            }

            addCategoryForm.addEventListener('submit',e=>{ e.preventDefault(); addCategory(categoryInput.value); });
            addTaskForm.addEventListener('submit',e=>{ e.preventDefault(); addTask(); });

            function escapeHtml(s){return (s+'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));}

            render();
        })();
    </script>
    @endpush --}}

    @include('components.add-task-modal')
    @include('components.message-modal',['title'=>'Error', 'content'=>'Please add atleast one category'])
        @push('scripts')
        <script>
            const hasCategories = @json($hasCategories);
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('add-task-modal');
                const msgModal = document.getElementById('message-modal');
                const closeMsgModal = document.querySelector('.close-msg-modal');
                const taskForm = document.getElementById('task-form');
                const modalTitle = document.getElementById('addTaskTitle');
                const taskIdInput = document.getElementById('task-id');
                const taskSubmitButton = document.getElementById('task-submit-btn');

                if (!modal) return;
                const overlay = modal.querySelector('.modal-overlay');
                const closeButtons = modal.querySelectorAll('button[aria-label="Close"], .modal-footer .btn-ghost');

                const formatDateTimeLocal = (value) => {
                    if (!value) return '';
                    return value.replace(' ', 'T').slice(0, 16);
                };

                function setTaskModalMode(mode, task = null) {
                    const isEdit = mode === 'edit';
                    const taskTitleInput = taskForm.querySelector('input[name="task_title"]');
                    const taskDescriptionInput = taskForm.querySelector('textarea[name="task_description"]');
                    const taskStartInput = taskForm.querySelector('input[name="task_start"]');
                    const taskHoursInput = taskForm.querySelector('input[name="working_hours"]');
                    const categorySelect = taskForm.querySelector('select[name="category_id"]');

                    modalTitle.textContent = isEdit ? 'Edit Task' : 'Add Task';
                    taskForm.action = isEdit ? '/editTask' : '/tasks';
                    taskSubmitButton.textContent = isEdit ? 'Update Task' : 'Create Task';
                    taskForm.reset();
                    taskIdInput.value = isEdit && task ? (task.id || '') : '';

                    if (isEdit && task) {
                        categorySelect.value = task.category_id || categorySelect.value;
                        taskTitleInput.value = task.task_title || '';
                        taskDescriptionInput.value = task.task_description || '';
                        taskStartInput.value = formatDateTimeLocal(task.task_start || '');
                        taskHoursInput.value = task.working_hours || 0;
                    }
                }

                function openMessageModal(){
                    msgModal.setAttribute('aria-hidden','false');
                    document.body.style.overflow = 'hidden';
                }

                function close_Msg_Modal(){
                    msgModal.setAttribute('aria-hidden','true');
                    document.body.style.overflow="";
                }

                function closeModal() {
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }

                function openModal(mode, task = null) {
                    if (!hasCategories) {
                        openMessageModal();
                        return;
                    }

                    setTaskModalMode(mode, task);
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                    const first = modal.querySelector('input,select,textarea,button');
                    if (first) first.focus();
                }

                document.getElementById('add-task-btn')?.addEventListener('click', (e) => {
                    e.preventDefault();
                    openModal('add');
                });

                document.querySelectorAll('.edit-task-btn').forEach((btn) => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const task = {
                            id: btn.dataset.taskId,
                            task_title: btn.dataset.taskTitle,
                            task_description: btn.dataset.taskDescription,
                            task_start: btn.dataset.taskStart,
                            working_hours: btn.dataset.workingHours,
                            category_id: btn.dataset.categoryId,
                        };
                        openModal('edit', task);
                    });
                });

                overlay?.addEventListener('click', () => closeModal());
                closeButtons.forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); closeModal(); }));
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
                closeMsgModal?.addEventListener('click', () => close_Msg_Modal());
            });

            function filterTasks(categoryId, button) {
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.add('text-dark','bg-white');
                    btn.classList.remove('text-white', 'bg-primary');
                });

                button.classList.add('text-white', 'bg-primary');
                button.classList.remove('text-dark', 'bg-white');

                document.querySelectorAll('.task-item').forEach(task => {
                    if (categoryId === 'all' || task.dataset.category === categoryId) {
                        task.style.display = '';
                    } else {
                        task.style.display = 'none';
                    }
                });
            }
        </script>
        @endpush

@endsection

@if($errors->hasAny(['category_id', 'task_title', 'task_description', 'task_start', 'working_hours']))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('add-task-modal');
            if (modal) modal.setAttribute('aria-hidden', 'false');
        });
    </script>
@endif
