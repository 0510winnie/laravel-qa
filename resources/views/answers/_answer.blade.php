<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <vote name="answer" :model="{{ $answer }}"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group ">
                    <button class="btn btn-primary" :disabled="isInvalid" >Update</button>
                    <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>
                </div>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        @can('update', $answer)
                        <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                        @endcan
                        @can('delete', $answer)
                        <button
                        @click="destroy" class="btn btn-sm btn-outline-danger" >Delete</button>
                        {{-- <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post"
                            class="form-delete">
                            @method('DELETE')
                            @csrf
                        </form> --}}
                        @endcan
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        {{-- @include('shared._author', [
                        'model' => $answer,
                        'label' => 'Answered'
                        ]) --}}
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>

        </div>
    </div>
</answer>
