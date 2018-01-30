$(document).ready(function() {
	$.toast.options.position = { top: '20px', right: '80px' };
	$.toast.options.stack = false;

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('.balance-nav').on('click', 'li:not(.active)', function() {
		$(this).addClass('active').siblings().removeClass('active');
	});
	
    /* FAQ спойлеры */
    $('.faq-i').click(function() {
        $(this).find('.faq-mess').slideToggle(); 
        if($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $(this).addClass('closed');
        } else {
            $(this).removeClass('closed');
            $(this).addClass('opened');
        }
    });
    
    /* Открытие кейса */
    $('.open-link').click(function() {
        if($('.open-link').attr('disabled') == 'disabled') return false;
        var case_id = $(this).attr('data-case_id');
        $.ajax({
            url : '/case/open',
            type : 'post',
            data : {
                case_id : case_id
            },
            success : function(data) {
                if(!data.success) {
					$.toast({text: data.msg, icon: data.icon});
                    return;
                }
                
                var text = $('.open-link').text();
                $('#line').css('margin-left', '0px');
                // Парс линии.
                var html = '';
                for(var i = 0; i < data.list.length; i++) {
					if(data.list[i].type == 0) {
						if(data.list[i].rarity !== 0) {
							html += '<li data-id="'+i+'"><span><img src="../assets/images/coin/'+data.list[i].rarity+'.png" alt="" /><b>'+data.list[i].price+'</b></span></li>';
						} else {
							html += '<li data-id="'+i+'"><span><img src="'+data.list[i].img+'" alt="" /><b>'+data.list[i].price+'</b></span></li>';
						}
					} else {
						html += '<li data-id="'+i+'"><span><img src="'+data.list[i].img+'" alt="" /><b></b></span></li>';
					}
                }
				console.log(data);
                $('#line').html(html);
				var k = 11464 - Math.round(getRandomArbitary(1, 130));
                $('#line').animate({'margin-left' : '-' + k + 'px'}, 8000, 'easeOutQuint', function() {
                    $(".open-link").attr("disabled", false);
                    $('.open-link').text(text);
                });
                $(".open-link").attr("disabled", true);
                $('.open-link').text('Открываем...');
				setTimeout(function() {
					audio('/assets/sound/finish.mp3', 0.5);
					$('.rulet li').removeClass('active');
					if (data.drop.type == 0) {
				    if(data.drop.rarity !== 0) {
						$('.coin-new span img').attr('src', '../assets/images/coin/'+data.drop.rarity+'.png');
					} else {
						$('.coin-new span img').attr('src', data.drop.img);
					}
						$('.coin-new b').text(data.drop.price);
						$('#modal-3').arcticmodal();
					} else {
						$('#take_item').attr('data-userid', data.user_id);
						$('#sell_item').attr('data-userid', data.user_id);
						$('#take_item').attr('data-id', data.drop_id);
						$('#sell_item').attr('data-id', data.drop_id);
						$('.coin-new b').text('');
						$('.coin-new span img').attr('src', data.drop.img);
						$('#sell_item .sp_value').text(data.drop.price);
						$('#modal-4').arcticmodal();
					}
					$(".open-link").removeAttr("disabled");
				}, 8000);
				
				var start = parseInt( $('#line').css('margin-left') ),
					slot_width = $('#line li').outerWidth(true),
					offset = (79 + Math.min(Math.max(Math.random(), .1), .9)) * slot_width,
					position = 0,
					interval = setInterval(function(){
						var offset = parseInt( $('#line').css('margin-left') ) - start,
							position_actual = Math.floor(offset / slot_width);

						if(position_actual !== position){
							audio('/assets/sound/click.mp3', 0.5);
						}
						position = position_actual;
					}, 80);
            },
            error : function(data) {
                console.log(data.responseText);
            }
        });
    });
	
	$('#f_wallet').keydown(function(event) {
		if (event.shiftKey === true) return false;
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
           (event.keyCode == 65 && event.ctrlKey === true) || 
           (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
        } else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) && (event.keyCode < 65 || event.keyCode > 90 )) {
                event.preventDefault(); 
            }   
        }
    });

	
	$('#withdraw').click(function(){
		var system = $('.balance-nav .active').attr('data-type');
		var value = $('#f_value').val();
		var wallet = $('#f_wallet').val();
		$.ajax({
            url : '/withdraw',
            type : 'post',
            data : {
                system : system,
                value : value,
				wallet : wallet
                
            },
			success : function(data) {
				$.toast({text: data.msg, icon: data.icon});
				$('#modal-2').arcticmodal('close'); return false;
			},
            error : function(data) {
                console.log(data.responseText);
            }
        });
	});
	
	$('.takeItem').click(function(event){
		var that = $(event.target).closest('.coin-i');
		var user_id = $('#takeItem').attr('data-userid');
		var drop_id = $('#takeItem').attr('data-id');
		$.ajax({
            url : '/takeItem',
            type : 'post',
            data : {
                user_id : user_id,
                drop_id : drop_id
            },
			success : function(data) {
				$.toast({text: data.msg, icon: data.icon});
				that.remove();
			},
            error : function(data) {
                console.log(data.responseText);
            }
        });
	});
	
	$('.sellItem').click(function(event){
		var that = $(event.target).closest('.coin-i');
		var user_id = $('#sellItem').attr('data-userid');
		var drop_id = $('#sellItem').attr('data-id');
		$.ajax({
            url : '/sellItem',
            type : 'post',
            data : {
                user_id : user_id,
                drop_id : drop_id
            },
			success : function(data) {
				$.toast({text: data.msg, icon: data.icon});
				$('.mini-profile-balance b:first').text(parseFloat(parseFloat($('.mini-profile-balance b:first').text()) + parseFloat(data.item_price)));
				that.remove();
			},
            error : function(data) {
                console.log(data.responseText);
            }
        });
	});
	
	$('#take_item').click(function(){
		var user_id = $('#take_item').attr('data-userid');
		var drop_id = $('#take_item').attr('data-id');
		$.ajax({
            url : '/takeItem',
            type : 'post',
            data : {
                user_id : user_id,
                drop_id : drop_id
            },
			success : function(data) {
				$.toast({text: data.msg, icon: data.icon});
				$('#modal-4').arcticmodal('close'); return false;
			},
            error : function(data) {
                console.log(data.responseText);
            }
        });
	});
	
	$('#sell_item').click(function(){
		var user_id = $('#sell_item').attr('data-userid');
		var drop_id = $('#sell_item').attr('data-id');
		$.ajax({
            url : '/sellItem',
            type : 'post',
            data : {
                user_id : user_id,
                drop_id : drop_id
            },
			success : function(data) {
				$.toast({text: data.msg, icon: data.icon});
				$('.mini-profile-balance b:first').text(parseFloat(parseFloat($('.mini-profile-balance b:first').text()) + parseFloat(data.item_price)));
				$('#modal-4').arcticmodal('close'); return false;
			},
            error : function(data) {
                console.log(data.responseText);
            }
        });
	});
	
	$('a[href*=#]').bind("click", function(e){
		var anchor = $(this);
		$('html, body').stop().animate({
		scrollTop: $(anchor.attr('href')).offset().top
		}, 800);
		e.preventDefault();
	});
    
});

function getLiPosition(e) {
    var t = e.css("margin-left").split('.');
    return 80 === t.length ? parseInt(t[0]) : 10
}

function getRandomArbitary(min, max){
	return Math.random() * (max - min) + min;
}

function audio(audio, vol) {
	var newgames = new Audio();
	newgames.src = audio;
	newgames.volume = vol;
	newgames.play();
}