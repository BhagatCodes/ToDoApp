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
                        <p class="text-sm px-2 py-1 text-primary border border-primary rounded-sm">{{ optional($task->category)->name ?? '—' }}</p>
                    </div>
                @endforeach
            @endif
        </div>
        <button id="add-task-btn" class="btn btn-primary flex-none mt-3">Add Task</button>
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
                const openBtn = document.querySelector('#add-task-btn');
                const modal = document.getElementById('add-task-modal');
                const msgModal = document.getElementById('message-modal');
                const closeMsgModal = document.querySelector('.close-msg-modal');
                if (!modal) return;
                const overlay = modal.querySelector('.modal-overlay');
                const closeButtons = modal.querySelectorAll('button[aria-label="Close"], .modal-footer .btn-ghost');

                function openModal() {
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                    const first = modal.querySelector('input,select,textarea,button');
                    if (first) first.focus();
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

                openBtn?.addEventListener('click', (e) => { e.preventDefault();
                    if(!hasCategories){
                        openMessageModal();
                        return;
                    }
                    openModal(); 
                });
                overlay?.addEventListener('click', () => closeModal());
                closeButtons.forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); closeModal(); }));
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
                closeMsgModal.addEventListener('click', () => close_Msg_Modal());
            });
            function filterTasks(categoryId, button) {
            // Change active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.add('text-dark','bg-white');
                btn.classList.remove('text-white', 'bg-primary');
            });

                button.classList.add('text-white', 'bg-primary');
                button.classList.remove('text-dark', 'bg-white');


                // Filter tasks
                document.querySelectorAll('.task-item').forEach(task => {

                    if (categoryId === 'all' ||
                        task.dataset.category === categoryId) {

                        task.style.display = '';
                    } else {
                        task.style.display = 'none';
                    }

                });
            }
        </script>
        @endpush

@endsection

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('add-task-modal');
            if (modal) modal.setAttribute('aria-hidden','false');
        });
    </script>
@endif
