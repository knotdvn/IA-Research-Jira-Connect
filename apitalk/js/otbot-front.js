$(document).ready(function(){
            //the first part of human behavior starts with the login button being clicked
            $('#ot_login').click(function(){
              $('#wait').show();
              $('#credentials').hide();
              var ot_username = $('#ot_username').val();
              var ot_password =$('#ot_password').val();
              if(ot_username != '' && ot_password != ''){
                otbot_attempt_login(ot_username, ot_password);
                
              }else{
                alert("Please supply a password and a username to login.");
                $('#credentials').show();
                $('#wait').hide();
              }
            });
            
            //the 2nd part of human behaivor involves selecting a project
            
            var projectSelect;
          $('#projects').delegate('li', 'click', function () {
          // do stuff on click
          $('#status').append('  2. ' + $(this).attr('key') );
          $('#status').attr('otprojectkey',(' 2. ' + $(this).attr('key') ) );
          
          projectSelect = $(this);
          
          $('#project_go').show();
          $('#projects').find('ul').hide();
          $('#projects').find('h2').hide();
          $('#project_again').show();
          
        });
        
        //they have the right project
        $('#project_go').click(function(){
          $('#projects').hide();
          $('#wait').show();
          //this is where we make our THIRD ajax request
          $('#wait').show();
          otbot_issue_types( $(projectSelect).attr('key') );
          
        });//end click
        
        //what if they chose the wrong project
              $('#project_again').click(function(){
                $('#project_go').hide();
                $('#projects').find('ul').show();
                $('#project_again').hide();
            $('#status').text($('#status').attr('otusername'));           
              });//end function project again click
     
   
             //the 3rd part of human behaivor involves selecting an issue type
            
            var issueSelect;
            $('#issues').delegate('li', 'click', function () {
          // do stuff on click
            $('#status').append('  3. ' + $(this).text());
            $('#status').attr('otissuetype',(' 3. ' + $(this).text() ) );
            issueSelect = $(this);
            
            $('#issue_go').show();
            $('#issues').find('ul').hide();
            $('#issues').find('h2').hide();
            $('#issue_again').show();
        });
        
        //they have selected the right issue
        $('#issue_go').click(function(){
          $('#issues').hide();
          $('#creates').show();
        });//end click
            
            //what if the chose the wrong issue
              $('#issue_again').click(function(){
                $('#issue_go').hide();
                $('#issues').find('ul').show();
                $('#issue_again').hide();
                $('#status').text($('#status').attr('otusername') + $('#status').attr('otprojectkey' ) );
              });//end function project again click 
     
     
     
     
     
        
            
            
            /////////////This is the 5th and final part of human interaction
            //a filled out issue form and the create issue button clicked
            
            $('#create_go').click(function(){
              jQuery('#wait').show();
              otbot_create_issue(
                 $(projectSelect).attr('key'),
                 $(issueSelect).attr('issueid'),
                 $('#ot_summary').val(),
                 $('#ot_description').val()
               );//end create issue ajax paramater list
            });
            
          });