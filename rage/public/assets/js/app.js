$(document).ready(function() {
    
    var socket = io.connect(':8081');
    //Онлайн
    socket.on('online', function (data) {
    $('.stats-onlineNow').text(Math.abs(data));
    });
    // Обновление баланса
    socket.on('update_balance', function(data) {
        if(data.user == USER_ID) $('#balance').text(data.money);
    });
    
    // Лайв-лента
    socket.on('live_drops', function(data) {
        var html = '';
        if(data.item_type == 0) {
				if(data.item_rarity !== 0) {
					html += '<li class="live-item" style="background: url(../assets/images/coin/'+data.item_rarity+'.png) no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/'+data.user_id+'"><img src="'+data.user_avatar+'" alt="">'+data.item_price+'</a></li>';
					html += '';
				} else {
					html += '<li class="live-item" style="background: url('+data.item_img+') no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/'+data.user_id+'"><img src="'+data.user_avatar+'" alt="">'+data.item_price+'</a></li>';
					html += '';
				}
            } else {
				html += '<li class="live-item" style="background: url('+data.item_img+') no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/'+data.user_id+'"><img src="'+data.user_avatar+'" alt=""></a></li>';
				html += '';
			}
        
        $('#live_drops').prepend(html);
    });


    
});