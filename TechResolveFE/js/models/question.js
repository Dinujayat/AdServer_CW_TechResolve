// Define Question Model
var Question = Backbone.Model.extend({
    defaults: {
        id: 'id',
        user_id: 'user_id',
        question_title: 'question_title',
        question_body: 'question_body',
        created_date: 'created_date'
    }
});
