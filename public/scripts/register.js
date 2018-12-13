$(function() {
	// UserName
	var error = '<div class="invalid-username"></div>';
	$(error).insertAfter($(".username"));

	$('.username').keyup(
			function(e) {
				var name = $('.username').val();
				switch (true) {
				case (name == ''):
					$('.username').addClass('invalid');
					$('.invalid-username').text('Username missing!');
					$('invalid-username').show();
					e.preventDefault();
					break;
				case (name.length <= 4):
					$('.username').addClass('invalid');
					$('.invalid-username').text('At least 5 chars for name!');
					$('.invalid-username').show();
					e.preventDefault();
					break;
				case (name.length >= 254):
					$('.username').addClass('invalid');
					$('.invalid-username').text(
							'No more than 255 chars for username!');
					$('.invalid-username').show();
					e.preventDefault();
					break;
				default:
					$('.username').removeClass('invalid');
					$('.invalid-username').hide();
				}
			});

	// validation email function
	function validateEmail(email) {
		var regex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return regex.test(email);
	}

	// Email
	var error = '<div class="invalid-email"></div>';
	$(error).insertAfter($(".email"));

	$('.email').keyup(function(e) {
		var email = $('.email').val();
		switch (true) {
		case (email == ''):
			$('.email').addClass('invalid');
			$('.invalid-email').text('Email missing');
			$('.invalid-email').show();
			e.preventDefault();
			break;
		case (!validateEmail(email)):
			$('.email').addClass('invalid');
			$('.invalid-email').text('Invalid email');
			$('.invalid-email').show();
			e.preventDefault();
			break;
		default:
			$('.email').removeClass('invalid');
			$('.invalid-email').hide();
		}
	});

	// Password
	var error = '<div class="invalid-password"></div>';
	$(error).insertAfter($(".password"));
	var error2 = '<div class="invalid-password2"></div>';
	$(error2).insertAfter($(".password2"));

	$('.password').keyup(function(e) {
		var password = $('.password').val();
		switch (true) {
		case (password == ''):
			$('.password').addClass('invalid');
			$('.invalid-password').text('Password missing');
			$('.invalid-password').show();
			e.preventDefault();
			break;
		case (password.length < 8):
			$('.password').addClass('invalid');
			$('.invalid-password').text('At least 8 chars for password');
			$('.invalid-password').show();
			e.preventDefault();
			break;
		default:
			$('.password').removeClass('invalid');
			$('.invalid-password').hide();
		}
	});

	// Password Confirmation
	$('.password2').keyup(function(e) {
		var password = $('.password').val();
		var password2 = $('.password2').val();
		if (password2 !== password) {
			$('.password2').addClass('invalid');
			$('.invalid-password2').text('Password does not match the confirm password.');
			$('.invalid-password2').show();
			e.preventDefault();
		} else {
			$('.password2').removeClass('invalid');
			$('.invalid-password2').hide();
		}
	});
/*
	$(".register").submit(function(e) {
		var username = $('.username').hasClass('invalid');
		var email = $('.email').hasClass('invalid');
		var password = $('.password').hasClass('invalid');
		var password2 = $('.password2').hasClass('invalid');

		console.log("u " + username);
		console.log("e " + email);
		console.log("p " + password);
		console.log("p2 " + password2);
var end = (username && email && password && password2);
console.log(end);
		if (!(username && email && password && password2)) {
			$('.register').append('<strong>Success</strong>')
			e.preventDefault();
		} else {
			e.preventDefault();
			$('.register').append('<strong>fail</strong>')
		}
	})
	*/
});