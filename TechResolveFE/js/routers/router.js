// defines how the urls work in this application 
var TechResolveAppRouter = Backbone.Router.extend({
    routes: {
        "register":"showRegisterPage",
        "login":"showLoginPage",
    },

    showRegisterPage: function(){
        // render the register component
        var registerView = new RegisterView();
        registerView.render();
    }

});

// Initialize the router
var appRouter = new TechResolveAppRouter();
Backbone.history.start();