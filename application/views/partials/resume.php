    <div id="resume_layout_1" class="resume">
        <div id="inner">
            <div class="row-fluid">
                <div class="span8">
                    <h1><%= json_data.formattedName %></h1>
                    <h3 class="light"><%= json_data.headline %></h3>
                </div>
                <div class="span4">
                    <h4 class="text-right light"><%= json_data.emailAddress %></h4>
                    <h4 class="text-right light">noahhamann.com</h4>
                    <h4 class="text-right light">(313) - 867-5309</h4>
                </div>
            </div> 
            <div class="line-separator"></div>
            <div class="row-fluid resume-section">
                <div class="span3">
                    <h4>Profile</h4>
                </div>
                <div class="span9">
                    <p>
                    <%= json_data.summary %>
                    </p>
                </div>
            </div>
            <!-- 
            <div class="line-separator"></div>
            <div class="row-fluid resume-section">
                <div class="span3">
                    <h4>Profile</h4>
                </div>
                <div class="span3">
                    <h4>Web Design</h4>
                    <p>
                    Assertively exploit wireless initiatives rather than synergistic core competencies.
                    </p>
                </div>
                <div class="span3">
                    <h4>Web Design</h4>
                    <p>
                    Assertively exploit wireless initiatives rather than synergistic core competencies.
                    </p>
                </div>
                <div class="span3">
                    <h4>Web Design</h4>
                    <p>
                    Assertively exploit wireless initiatives rather than synergistic core competencies.
                    </p>
                </div>
            </div>
            --> 
            <div class="line-separator"></div>
            <div class="row-fluid resume-section">
                <div class="span3">
                    <h4>Skills</h4>
                </div>
                <div class="span9">
                    <% cur = 0 %>
                    <% for(var i=0; i<json_data.skills.values.length; i++){ %>
                        <% skill = json_data.skills.values[i].skill %>
                    
                        <% if(cur == 0){ %>
                            <div class="row-fluid">
                        <% } %>
                    
                        <div class="span4">
                            <h4 class="light"><%= skill.name %></h4>
                        </div>
                    
                        <% if(cur == 2 || (i+1) == json_data.skills.values.length){ %>
                            </div>
                            <% cur = 0 %>
                        <% }else{ %>
                            <% cur++ %>
                        <% } %>
                    <% } %>
                </div>
            </div> 
            <div class="line-separator"></div>
            <div class="row-fluid resume-section">
                <div class="span3">
                    <h4>Experience</h4>
                </div>
                <div class="span9">
                    
                    <% for(var i=0; i<json_data.positions.values.length; i++){ %>
                    <% position = json_data.positions.values[i] %>
                    <h4><%= position.company.name %></h4>
                    <p><%= position.title %></p>
                    <p>
                        <%= position.summary %>
                    </p>
                        <% if((i+1) < json_data.positions.values.length){ %>
                        <div class="line-separator"></div>
                        <% } %>
                    <% } %>
                </div>
            </div> 
            <div class="line-separator"></div>
            <div class="row-fluid resume-section">
                <div class="span3">
                    <h4>Education</h4>
                </div>
                <div class="span9">
                    <% for(var i=0; i<json_data.educations.values.length; i++){ %>
                    <% edu = json_data.educations.values[i] %>
                    <h4><%= edu.schoolName %></h4>
                    <p><%= edu.degree %>, <%= edu.fieldOfStudy %>, <%= edu.startDate.year %> - <%= edu.endDate.year %></p>
                        <% if((i+1) < json_data.educations.values.length){ %>
                        <div class="line-separator"></div>
                        <% } %>
                    <% } %>
                </div>
            </div> 
        </div><!-- // inner -->
    </div><!--// doc -->
