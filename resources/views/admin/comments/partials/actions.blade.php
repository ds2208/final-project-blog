<td class="text-center">
    <div class="btn-group">
        <a href="{{$comment->blog->getFrontUrl()}}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i>
        </a>
        @if($comment->index == 1)
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#disable-modal"
            data-action="disable"
            data-id="{{$comment->id}}"
            data-name="{{$comment->name}}"
            >
            <i class="fas fa-minus-circle"></i>
        </button>
        @else
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#enable-modal"
            data-action="enable"
            data-id="{{$comment->id}}"
            data-name="{{$comment->name}}"
            >
            <i class="fas fa-check"></i>
        </button>
        @endif
    </div>
</td>