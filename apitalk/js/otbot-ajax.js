//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
//this is also the app flow!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
///////////////////////////////////////////////////////////////////////////////////////////////

var cookieName;
var ajaxurl = "apitalk/endpoint.php"; 


/// #1 ///
//javascript to grab the login cookie
function otbot_attempt_login(ot_username, ot_password){

  $.post(
    
    // see tip #1 for how we declare global javascript variables
    
    ajaxurl,
    {// here we declare the parameters to send along with the request
      
    action : 'otbot_attempt_login',
    // other parameters can be added along with "action"
    //requests only come from pages which originate with our server
    
    //username and password for ot
    otbot_username: ot_username,
    otbot_password: ot_password
    },
    
      function( response ) {
        $('#wait').hide();
      if(response =="ERROR!!!"){
        alert("Password or Username is incorrect, please try again.");
        $('#credentials').show();
      }else{
        cookieName = response;
        $('#status').append('1. ' + ot_username );
        $('#status').attr('otusername',('1. ' + ot_username) );
        otbot_query_projects();
        $('#wait').show();
        
      }
    });//end ajax post

}//end otbot_attempt_login

/// End #1 ///

/// #2///
//javascript to grab the login cookie
function otbot_query_projects(){

  $.post(
    
    // see tip #1 for how we declare global javascript variables
    
    ajaxurl,
    {// here we declare the parameters to send along with the request
        
    action : 'otbot_query_projects',
    // other parameters can be added along with "action"
  
    otbot_cookieName: cookieName
    },
    
      function( response ) {
        $('#wait').hide();
        if(response == 'ERROR!!!'){
          alert("Error retrieving Project List");
        }else{
          $('#projects').show();
          $('#projects').append( response);
      
        }
      
      
    });//end ajax post

}//end otbot_query projects

/// End #2 ///

/// #3///
//returns all of the issue types for a given project
function otbot_issue_types(key){

  $.post(
    
    // see tip #1 for how we declare global javascript variables
    
    ajaxurl,
    {// here we declare the parameters to send along with the request
        
    action : 'otbot_issue_types',
    // other parameters can be added along with "action"
    
    otbot_project_key: key,
    otbot_cookieName: cookieName
    },
    
      function( response ) {
          $('#wait').hide();
        if(response == 'ERROR!!!'){
          alert("Error retrieving Issue Types");
        }else{
          $('#issues').show();
          $('#issues').append( response);
      
        }
      
    });//end ajax post

}//end otbot_issue types

/// End #3 ///




/// #5///
//sends all data to create an issue with assignee, then displays a successful operation.
function otbot_create_issue(key,issue,summary,description){

  $.post(
    
    // see tip #1 for how we declare global javascript variables
    
    ajaxurl,
    {// here we declare the parameters to send along with the request
        
    action : 'otbot_create_issue',
    // other parameters can be added along with "action"
  
    otbot_project_key: key,
    otbot_issueType: issue,
    otbot_summary: summary,
    otbot_description: description,
    otbot_cookieName: cookieName
    
    },
    
      function( response ) {
          if(response == 'ERROR!!!'){
          alert("Error creating Issue");
        }else{
      $('#wait').hide();
      $('#creates').hide();
      $('#ot_issue_link').attr('href','http://ot.syr.edu/browse/' +response);
      $('#ot_issue_link').text('Issue created at http://ot.syr.edu/browse/' + response);
      $('#ot_issue_link').show();
      }//end if no error
    });//end ajax post

}//end otbot_create_issue

/// End #5 ///



