function confirmPost(confirmText) {
	var agree = confirm(confirmText);
	if (agree)
		return true ;
	else
		return false ;
}

function enable_button(button, time) {
    var set_time = (time !== null ? time : 4000);
    window.setTimeout(function(){ 
    button.removeAttr('disabled');
    },set_time);
}

function replace_header(replacement_text) {
        $('#loading_header').empty();
        $('#loading_header').append(replacement_text);
}

function replace_text(replacement_text) {
    $('#loading_text').empty();
    $('#loading_text').append(replacement_text);
}

function hide_load() {
    $('#loading_image').attr('src', 'images/loading_blank.png');
}

function show_load() {
    $('#loading_image').attr('src', 'images/loading_white.gif');
}

$(document).ready(function(){

  // Hide div 2 by default
  $('#div_2').hide();
  $('#div_3').hide();
  $('#arrow_2').hide();
  $('#arrow_3').hide();

  $('#chineselink').click(function(){ 
      $('#div_1').hide();
	  $('#div_2').hide();
      $('#div_3').show();
	  $('#arrow_1').hide();
	  $('#arrow_2').hide();
	  $('#arrow_3').show();
  });
  
  $('#russianlink').click(function(){ 
      $('#div_1').hide();
	  $('#div_3').hide();
      $('#div_2').show();
	  $('#arrow_1').hide();
	  $('#arrow_2').show();
	  $('#arrow_3').hide();
  });

  $('#italianlink').click(function(){ 
      $('#div_3').hide();
	  $('#div_2').hide();
      $('#div_1').show();
	  $('#arrow_1').show();
	  $('#arrow_2').hide();
	  $('#arrow_3').hide();
  }); 
});

function checkboxlimit(checkgroup, limit){
	var checkgroup=checkgroup
	var limit=limit
	for (var i=0; i<checkgroup.length; i++){
		checkgroup[i].onclick=function(){
		var checkedcount=0
		for (var i=0; i<checkgroup.length; i++)
			checkedcount+=(checkgroup[i].checked)? 1 : 0
		if (checkedcount>limit){
			alert("You can only use a maximum of "+limit+" weapons each round.")
			this.checked=false
			}
		}
	}
}