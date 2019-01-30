export default {
    modify (user, model) {
        return user.id === model.user_id;
    },
    //instead of calling it question or answer, we call it model because this argument can be either question or answer (in Policies, their authorization logics are quite similar)

    accept (user, answer) {
        return user.id === answer.question.user_id;
    },

    deleteQuestion(user, question) {
        return user.id === question.user_id && question.answers_count < 1 ;
    }
}

