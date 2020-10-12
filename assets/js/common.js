$('.loginsubmit').on('click',function(){
  $("#login-form").validate({
    // Specify validation rules
    rules: {
      username: "required",
      password: {
        required: true,
        minlength: 5
      }
    },
    // Specify validation error messages
    messages: {
      username: "Please enter your username",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      }
    },
    submitHandler: function(form) {
		$.ajax({
			url : "Login/checkLogin",
			type: "POST",
			data : $('#login-form').serialize(),
			success: function(response)
			{
				var response = jQuery.parseJSON(response);
				if(response.result == 'success')
				{
					window.location.href = "Main";
				}
				else
				{
					$('.errorMessage').remove();
					$('<p class="text-center errorMessage">'+response.message+'</p>').insertAfter(".submitDiv");
				}
			},
			error: function (response)
			{
				alert("Something went wrong!");
			}
		});
    }
  });
});

$('.registersubmit').on('click',function(){
  $("#register-form").validate({
    // Specify validation rules
    rules: {
      username: "required",
      password: {
        required: true,
        minlength: 5
      }
    },
    // Specify validation error messages
    messages: {
      username: "Please enter your username",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      }
    },
    submitHandler: function(form) {
		$.ajax({
			url : "checkRegister",
			type: "POST",
			data : $('#register-form').serialize(),
			success: function(response)
			{
				var response = jQuery.parseJSON(response);
				if(response.result == 'success')
				{
					$('.errorMessage').remove();
					$('<p class="text-center errorMessage">'+response.message+'</p>').insertAfter( ".registersubmit" );
				}
				if(response.result == 'exists')
				{
					$('.errorMessage').remove();
					$('<p class="text-center errorMessage">'+response.message+'</p>').insertAfter(".registersubmit");
				}
			},
			error: function (response)
			{
				alert("Something went wrong!");
			}
		});
    }
  });
});

$('.logout').on('click',function(){
	window.location.href = $(".baseurl").val()+"Login/logoutUser";
});
$(document).ready(function () {
  $('#listgames').DataTable();
});
var username = $('.username').val();
var seconds=60;
var timer;
var dragonActions = ["attack", "powerattack"];
function timerFunction() {
  if(seconds < 60) {
    document.getElementById("timer").innerHTML = seconds+' seconds';
  }
  if (seconds > 0 ) {
	 seconds--;
  } else {
	 clearInterval(timer);
	 $('.actionbuttons').addClass('d-none');
	 $('.playagain').removeClass('d-none');
	 var playerFinalHealth = $('#playerhealth').attr('aria-valuenow');
	 var dragonFinalHealth = $('#dragonhealth').attr('aria-valuenow');
	 $.ajax({
		url : "Playgame/updateScore",
		type: "POST",
		data : {playerFinalHealth:playerFinalHealth,dragonFinalHealth:dragonFinalHealth}
	 });
	 if(parseInt(playerFinalHealth) > parseInt(dragonFinalHealth)){
		 $('.matchresult').val("You Won!");
	 }else{
		 $('.matchresult').val("You Lost!");
	 }
  }
}

$('#startgame').on('click',function(){
  $('#startgame').remove();
  $('.actionbuttons').removeClass('d-none');
  if(!timer) {
    timer = window.setInterval(function() {
      timerFunction();
    }, 1000);
	
	window.setInterval(function() {
		if(seconds > 0){
			setPlayerHealth();
		}
	}, 10000);
  }
  $.ajax({
	url : "Playgame/startGame",
	type: "POST",
	data : {}
 });
});

$('.attack').on('click',function(){
	reduceDragonHealth(1,5,'attack');
});

$('.powerattack').on('click',function(){
	reduceDragonHealth(6,10,'powerattack');
});

$('.heal').on('click',function(){
	increasePlayerHealth();
});

$('.surrender').on('click',function(){
	seconds = 0;
	 clearInterval(timer);
	 $('.actionbuttons').addClass('d-none');
	 $('.playagain').removeClass('d-none');
	 var playerFinalHealth = $('#playerhealth').attr('aria-valuenow');
	 var dragonFinalHealth = $('#dragonhealth').attr('aria-valuenow');
	 $.ajax({
		url : "Playgame/updateScore",
		type: "POST",
		data : {playerFinalHealth:playerFinalHealth,dragonFinalHealth:dragonFinalHealth}
	 });
	 $('.matchresult').val("You Lost!");
});

function setDragonHealth(){
	var randomDragonHealth = randomInteger(6,10);
	var currentDragonHealth = $('#dragonhealth').attr('aria-valuenow');
	if(currentDragonHealth >= 100 || (parseInt(currentDragonHealth) + parseInt(randomDragonHealth)) >= 100){
		randomDragonHealth = pos_to_neg(randomDragonHealth);
	}
	var newDragonHealth = parseInt(currentDragonHealth) + parseInt(randomDragonHealth);
	
	$('#dragonhealth').html(newDragonHealth+"%");
	$('#dragonhealth').attr('aria-valuenow',0);
	$('#dragonhealth').attr('aria-valuenow',newDragonHealth);
	$('#dragonhealth').css('width','0%');
	$('#dragonhealth').css('width',newDragonHealth+'%');
}

function setPlayerHealth(){
	var randomPlayerAction = randomInteger(0,1);
	randomPlayerAction = dragonActions[randomPlayerAction];
	var randomPlayerHealth = randomInteger(6,10);
	var currentPlayerHealth = $('#playerhealth').attr('aria-valuenow');
	if(currentPlayerHealth >= 100 || (parseInt(currentPlayerHealth) + parseInt(randomPlayerHealth)) >= 100){
		randomPlayerHealth = pos_to_neg(randomPlayerHealth);
	}
	var newPlayerHealth = parseInt(currentPlayerHealth) + parseInt(randomPlayerHealth);
	$.ajax({
		url : "Playgame/addComment",
		type: "POST",
		data : {randomHealth:randomPlayerHealth,randomAction:randomPlayerAction,attacker:'Dragon',defender:username},
		success: function(response)
		{
			var response = jQuery.parseJSON(response);
			if(response.result == 'success')
			{
				$('#playerhealth').html(newPlayerHealth+"%");
				$('#playerhealth').attr('aria-valuenow',0);
				$('#playerhealth').attr('aria-valuenow',newPlayerHealth);
				$('#playerhealth').css('width','0%');
				$('#playerhealth').css('width',newPlayerHealth+'%');
				$('.commentarybox').empty();
				$('.commentarybox').append(response.html);
			}
		},
		error: function (response)
		{
			alert("Something went wrong!");
		}
	});
}

function reduceDragonHealth(start, end, action){
	var randomDragonHealth = randomInteger(start,end);
	var currentDragonHealth = $('#dragonhealth').attr('aria-valuenow');
	randomDragonHealth = pos_to_neg(randomDragonHealth);
	
	var newDragonHealth = parseInt(currentDragonHealth) + parseInt(randomDragonHealth);
	$.ajax({
		url : "Playgame/addComment",
		type: "POST",
		data : {randomHealth:randomDragonHealth,randomAction:action,attacker:username,defender:'dragon'},
		success: function(response)
		{
			var response = jQuery.parseJSON(response);
			if(response.result == 'success')
			{
				$('#dragonhealth').html(newDragonHealth+"%");
				$('#dragonhealth').attr('aria-valuenow',0);
				$('#dragonhealth').attr('aria-valuenow',newDragonHealth);
				$('#dragonhealth').css('width','0%');
				$('#dragonhealth').css('width',newDragonHealth+'%');
				$('.commentarybox').empty();
				$('.commentarybox').append(response.html);
			}
		},
		error: function (response)
		{
			alert("Something went wrong!");
		}
	});
	
	window.setInterval(function() {
		if(seconds > 0){
			setDragonHealth();
		}
	}, 10000);
}

function increasePlayerHealth(){
	var randomPlayerHealth = randomInteger(1,10);
	var currentPlayerHealth = $('#playerhealth').attr('aria-valuenow');
	if(currentPlayerHealth < 100 && (parseInt(currentPlayerHealth) + parseInt(randomPlayerHealth)) < 100){
		//randomPlayerHealth = pos_to_neg(randomPlayerHealth);
		var newPlayerHealth = parseInt(currentPlayerHealth) + parseInt(randomPlayerHealth);
		$.ajax({
			url : "Playgame/addComment",
			type: "POST",
			data : {randomHealth:randomPlayerHealth,randomAction:'heal',attacker:username,defender:''},
			success: function(response)
			{
				var response = jQuery.parseJSON(response);
				if(response.result == 'success')
				{
					$('#playerhealth').html(newPlayerHealth+"%");
					$('#playerhealth').attr('aria-valuenow',0);
					$('#playerhealth').attr('aria-valuenow',newPlayerHealth);
					$('#playerhealth').css('width','0%');
					$('#playerhealth').css('width',newPlayerHealth+'%');
					$('.commentarybox').empty();
					$('.commentarybox').append(response.html);
				}
			},
			error: function (response)
			{
				alert("Something went wrong!");
			}
		});
	}
}

function randomInteger(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function pos_to_neg(num){
	return -Math.abs(num);
}