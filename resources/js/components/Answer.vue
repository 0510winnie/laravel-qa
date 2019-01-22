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
        cancel () {
            //when canel or undo the change, we simply retore the body property with old body that's stored in beforeEditCache
            this.body = this.beforeEditCache;
            this.editing = false;
        },
        update() {
            //when this method is called, will send our server an ajax request by utilizing axios library, to make ajax requestion through axios we can simply say
            axios.patch(this.endpoint,{
                body: this.body
            })
            //second argument is the data will be sent in object
            //here we don't need to pass csrf token such as we did when working with normal forms, since csrf token has been set by default by Laravel
            .then(res => {
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                alert(res.data.message);
            })
            .catch(err => {
                alert(err.response.data.message);
            });
        },
        destroy() {
            if(confirm('Are you sure?')) {
                axios.delete(this.endpoint)
                .then(res => {
                    $(this.$el).fadeOut(500, () => {
                        alert('res.data.message');
                    })
                });
            }
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
