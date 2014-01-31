$(function(){

//highlight the tab corresponding to the page we are on
$("#home a:contains('Home')").parent().addClass('active'); //means check if the page we are on has id="home" if so 
//check if there is an achor tag that contains the word Home as the click-able link home 
//I want you to do the following. 
$("#Artists a:contains('Artists')").parent().addClass('active');
$("#Register a:contains('Register')").parent().addClass('active');
$("#Schedule a:contains('Schedule')").parent().addClass('active');


//make drop  downs drop automatically 
$('ul.nav li.dropdown').hover(function(){
	$('.dropdown-menu',this).fadeIn();
}, function(){
 $('.dropdown-menu',this).fadeOut('fast');
});//hover



});


