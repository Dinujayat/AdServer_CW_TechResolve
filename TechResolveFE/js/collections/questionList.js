// Define Question Collection
var QuestionList = Backbone.Collection.extend({
    model: Question,
    url: 'http://localhost/TechResolveAPI/questions' 
});
