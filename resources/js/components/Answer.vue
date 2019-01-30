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
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>

                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
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
    import Vote from './Vote.vue';
    import UserInfo from './UserInfo.vue';
    import modification from '../mixins/modification';

    export default {
        props: ['answer'],
        mixins: [modification], //accept an array
        components: {
            Vote,
            UserInfo
        },
        data() {
            return {
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null,
            }
        },
        methods: {
            setEditCache() {
                //before editing, we store the old  answer body in the beforeEditCache property
                this.beforeEditCache = this.body;
            },
            restoreFromCache() {
                //when canel or undo the change, we simply retore the body property with old body that's stored in beforeEditCache
                this.body = this.beforeEditCache;
            },
            payload() {
                return {
                    body: this.body
                };
            },
            delete() {
                axios.delete(this.endpoint)
                    .then(res => {
                        this.$toast.success(res.data.message, "Success", { timeout: 2000 });
                        this.$emit('deleted');
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
