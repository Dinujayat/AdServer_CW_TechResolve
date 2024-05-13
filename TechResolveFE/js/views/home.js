// defines how the home page is to be rendered 

// Navbar view 
var NavbarView = Backbone.View.extend (
    {
        el: '#navrbar-container',
        
        initialize:function(){
            // loading the template using AJAX - w1809863 wink -|<
            // since the html content/template is kept seperate
            $.get('js/templates/navbar.html', function(templatecontent){
                this.template = _.template(templatecontent);
                this.render();
            }.bind(this));
        },

        render:function(){
            this.$el.html(this.template());
            return this;
        }
    }
);


var QuestionListView = Backbone.View.extend(
    {
        el: '#body-container',
        
        // to check when the button is clicked (whether the user is logged in or not)
        events: {
            'click .answer-btn': 'onAnswerButtonClick'
        },

        initialize:function(){
            // loading the template using AJAX - w1809863 wink -|<
            // since the html content/template is kept seperate
            $.get('js/templates/listOfQuestions.html', function(templatecontent){
                this.template = _.template(templatecontent);
                this.render();
            }.bind(this));


            // Create a new collection instance
            this.questions = new QuestionList();

            // Fetch data from API end point 
            this.questions.fetch({
                success: function() {
                    this.render();
                }.bind(this),
                error: function(collection, response) {
                    console.error('Error fetching data:', response);
                }
            });

        },

        render:function(){
            this.$el.html(this.template({ questions: this.questions.toJSON() }));
            return this;
        },

        onAnswerButtonClick: function() {
            // Making an API request to check if the user is logged in
            $.ajax({
                url: 'http://localhost/TechResolveAPI/authenticate', 
                type: 'GET',
                success: function(response) {
                    if (response.loggedIn) {
                        
                    } else {
                        // when not logged in, render register view
                        var registerView = new RegisterView();
                    }
                },
                error: function(error) {
                    console.error('Error checking login status:', error);
                }
            });
        }
        
    }
);



var FooterView = Backbone.View.extend(
    {
        el: '#footer-container',
        
        initialize:function(){
            // loading the template using AJAX - w1809863 wink -|<
            // since the html content/template is kept seperate
            $.get('js/templates/footer.html', function(templatecontent){
                this.template = _.template(templatecontent);
                this.render();
            }.bind(this));
        },

        render:function(){
            this.$el.html(this.template());
            return this;
        }
    }
);

var navbarView = new NavbarView();
var questionListView = new QuestionListView();
var footerView = new FooterView();
