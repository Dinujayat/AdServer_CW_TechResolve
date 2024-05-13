// defines the register views 

var RegisterView = Backbone.View.extend({
    el: '#body-container',
    
    events: {
        'submit #btn': 'onSignupFormSubmit' 
    },

    initialize:function(){
        // loading the template using AJAX - w1809863 wink -|<
        // since the html content/template is kept seperate
        $.get('js/templates/Signup.html', function(templatecontent){
            this.template = _.template(templatecontent);
            this.render();
        }.bind(this));
    },

    render: function() {
        this.$el.html(this.template());
        return this;
    },

    onSignupFormSubmit: function(event) {
        // Prevent default form submission
        event.preventDefault(); 

        // Get form data
        var formData = {
            fname: this.$('#fname').val(),
            lname: this.$('#lname').val(),
            username: this.$('#username').val(),
            email: this.$('#email').val(),
            password: this.$('#password').val(),
            cpassword: this.$('#confirm-password').val()
        };

        // Send form data to the API endpoint
        $.ajax({
            url: 'http://localhost/TechResolveAPI/register', 
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Signup successful:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error signing up:', error);
            }
        });
    }


});
