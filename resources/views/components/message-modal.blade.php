<div id="message-modal" class="modal" aria-hidden="true">
    <div class="modal-overlay" aria-hidden="true"></div>
    <div class="modal-dialog close-msg-modal" role="dialog" aria-modal="true" aria-labelledby="messageTitle">
        <div class="modal-header">
            <h3 id="addTaskTitle" class="text-lg font-semibold">{{$title}}</h3>
            <button type="button" class="btn btn-ghost" aria-label="Close">✕</button>
        </div>
        <p class="modal-footer justify-start">{{$content}}</p>
    </div>

</div>