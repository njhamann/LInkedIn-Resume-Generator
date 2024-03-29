// Generated by CoffeeScript 1.3.3
(function() {
  var m, r, resume, v;

  resume = function() {
    var ResumeConfigModel, ResumeConfigView, TEMPLATE;
    TEMPLATE = {
      resumeConfig: $('#resume_layout_1').html()
    };
    ResumeConfigModel = Backbone.Model.extend({
      idAttribute: 'id',
      initialize: function() {},
      defaults: {}
    });
    ResumeConfigView = Backbone.View.extend({
      el: '#resume_container',
      template: TEMPLATE.resumeConfig,
      initialize: function() {
        this.render();
      },
      render: function() {
        var data, templ;
        data = this.model.toJSON();
        templ = _.template(this.template);
        this.$el.html(templ(data));
      }
    });
    $(document).on('click', 'button#download_resume_button', function(e) {
      var markup;
      e.preventDefault();
      markup = $('#resume_container').html();
      $('#resume_markup_input').val(markup);
      $('#download_resume_form').submit();
    });
    return {
      view: ResumeConfigView,
      model: ResumeConfigModel
    };
  };

  r = new resume();

  m = new r.model(resumeData);

  console.log(resumeData);

  v = new r.view({
    model: m
  });

  window.resume = resume;

}).call(this);
