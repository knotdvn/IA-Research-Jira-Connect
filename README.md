IA-Research-Jira-Connect
========================

An ajax form for creating tickets in a jira instance.

The Jira rest api 5.07 is targeted. 


Just drop ticket-template.php and the apitalk directory into any theme on an HTTPS wordpress site. 

 add the following snippet to the themes functions.php

//start-snippet 
add_filter('init', 'ot_form_init');

function ot_form_init() { 
 if (is_page_template('ticket-template.php')) 
    include('apitalk/ot-connect-functions.php');
}//end function 
//-end snippet

Create an Orange Tracker page from the page template drop down.


