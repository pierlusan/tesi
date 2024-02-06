// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('90939343e33175b6a070', {
    cluster: 'eu'
});

var channel = pusher.subscribe('video-therapy');
channel.bind('notice', function(data) {
    var userData = JSON.parse(document.getElementById('user-info').dataset.user);
    //console.log(data['message']['utente'])
    if(Array.isArray(data['message']['utente'])){
        console.log('ciao')
        for(const id of data['message']['utente']){
            if(id === userData['id'].toString()){
                //alert(JSON.stringify(data['message']['messaggio']));
                iziToast.show({
                    title: 'Hey',
                    message: JSON.stringify(data['message']['messaggio'])
                });
            }
        }
    }else if(typeof data['message']['utente'] === 'string'){
        if(data['message']['utente'] === userData['id'].toString()){


            //alert(JSON.stringify(data['message']['messaggio']));
            iziToast.show({
                title: 'Hey',
                message: JSON.stringify(data['message']['messaggio'])
            });
        }
    }


});
