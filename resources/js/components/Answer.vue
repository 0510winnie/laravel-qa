<template>
    <div class="media post">
        <vote name="answer" :model="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group ">
                    <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                    <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>
                </div>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)"
                            @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>

                            <button
                            v-if="authorize('modify', answer)"
                            @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null,
            }
        },
        methods: {
            edit() {
                //before editing, we store the old  answer body in the beforeEditCache property
                this.beforeEditCache = this.body;
                this.editing = true;
            },
            cancel() {
                //when canel or undo the change, we simply retore the body property with old body that's stored in beforeEditCache
                this.body = this.beforeEditCache;
                this.editing = false;
            },
            update() {
                //when this method is called, will send our server an ajax request by utilizing axios library, to make ajax requestion through axios we can simply say
                axios.patch(this.endpoint, {
                        body: this.body
                    })
                    //second argument is the data will be sent in object
                    //here we don't need to pass csrf token such as we did when working with normal forms, since csrf token has been set by default by Laravel
                    .then(res => {
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                        this.$toast.success(res.data.message, "Success", {
                            timeoue: 3000
                        });
                    })
                    .catch(err => {
                        this.$toast.error(err.desponse.data.message, "Error", {
                            timeout: 3000
                        });
                    });
            },
            destroy() {
                this.$toast.question('Are you sure about that?', "Confirm", {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {

                            axios.delete(this.endpoint)
                                .then(res => {
                                    this.$emit('deleted');
                                });
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');

                        }],
                    ]
                });

            }
        },
        computed: {
            isInvalid() {
                return this.body.length < 1;
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },
    }

</script>
