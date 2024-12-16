(function( $ ) {
	'use strict';


	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
 

  $("#select_type_id").on("change", function(){
	var select_type_val = $(this).val();   
	 //alert(select_type_val);
	  $.ajax({ 
		url: schedule_time_ajax.custom_ajax_url, //did not same function wordpress susch as ajax_url
		type: "POST", 
		dataType: 'html',
		data: {
		  action:"schedule_ajax_action",
		  select_type_val: select_type_val
		},
		beforeSend: function(){ 
		  $("#child_account_head").html('<option>Select '+select_type_val+' Type'); 
		}, 
		success: function(html){
		  //console.log(html); 
		   $("#child_account_head").html(html);  
		}, 
	  }); 
  });   


  //cash flow
  
  $("#select_year_id").on("change", function(){
	var select_year_val = $(this).val();  
	var location ='?page=cash_flow_page&year='+select_year_val;
	window.location.href = location; 
	//   alert(select_year_val);
	//   $.ajax({ 
	// 	url: schedule_time_ajax.custom_ajax_url, //did not same function wordpress susch as ajax_url
	// 	type: "POST", 
	// 	dataType: 'html',
	// 	data: {
	// 	  action:"cashflow_ajax_action",
	// 	  select_year_val: select_year_val
	// 	},
	// 	beforeSend: function(){ 
	// 	  $("#cashflow_ajax_results").empty(); 
	// 	}, 
	// 	success: function(html){
	// 	   console.log(html); 
	// 	   $("#cashflow_ajax_results").html(html);  
	// 	}, 
	//   }); 
  }); 
 

 })(jQuery);


