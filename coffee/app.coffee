
resume = () ->
    TEMPLATE = 
        resumeConfig: $('#resume_layout_1').html()
    
    ResumeConfigModel = Backbone.Model.extend
        idAttribute: 'id'
        initialize: ->
        defaults: {} 
    
    ResumeConfigView = Backbone.View.extend
        el: '#resume_container'
        template: TEMPLATE.resumeConfig
        initialize: ->
            this.render()
            return
        render: ->
            data = this.model.toJSON()
            templ = _.template this.template
            this.$el.html templ data
            return
    
    $(document).on 'click', 'button#download_resume_button', (e) ->   
        e.preventDefault();
        markup = $('#resume_container').html()
        $('#resume_markup_input').val markup;
        $('#download_resume_form').submit()
        return 
    return {
        view: ResumeConfigView
        model: ResumeConfigModel 
    }
r = new resume()
m = new r.model(resumeData)
console.log resumeData
v = new r.view
    model: m

window.resume = resume
