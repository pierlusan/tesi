<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Room</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>


    @vite(['resources/css/room.css','resources/css/main.css'])

</head>
<body>

<header id="nav">
    <div class="nav--list">
        <button id="members__button">

        </button>

    </div>

    <div id="nav__links">
        <button id="chat__button"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" fill="#ede0e0" clip-rule="evenodd"><path d="M24 20h-3v4l-5.333-4h-7.667v-4h2v2h6.333l2.667 2v-2h3v-8.001h-2v-2h4v12.001zm-15.667-6l-5.333 4v-4h-3v-14.001l18 .001v14h-9.667zm-6.333-2h3v2l2.667-2h8.333v-10l-14-.001v10.001z"/></svg></button>
        <!-- <a class="nav__link" href="/">
            Lobby
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ede0e0" viewBox="0 0 24 24"><path d="M20 7.093v-5.093h-3v2.093l3 3zm4 5.907l-12-12-12 12h3v10h7v-5h4v5h7v-10h3zm-5 8h-3v-5h-8v5h-3v-10.26l7-6.912 7 6.99v10.182z"/></svg>
        </a> -->

    </div>
</header>

<main class="container">
    <div id="room__container">
        <section id="members__container">

            <div id="members__header">
                <p>Participants</p>
                <strong id="members__count">0</strong>
            </div>

            <div id="member__list">

            </div>


        </section>

        <section id="stream__container">

            <div id ="stream__box"></div>

            <div id="streams__container"></div>



            <div class="stream__actions">
                <button id="camera-btn" class="active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5 4h-3v-1h3v1zm10.93 0l.812 1.219c.743 1.115 1.987 1.781 3.328 1.781h1.93v13h-20v-13h3.93c1.341 0 2.585-.666 3.328-1.781l.812-1.219h5.86zm1.07-2h-8l-1.406 2.109c-.371.557-.995.891-1.664.891h-5.93v17h24v-17h-3.93c-.669 0-1.293-.334-1.664-.891l-1.406-2.109zm-11 8c0-.552-.447-1-1-1s-1 .448-1 1 .447 1 1 1 1-.448 1-1zm7 0c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3zm0-2c-2.761 0-5 2.239-5 5s2.239 5 5 5 5-2.239 5-5-2.239-5-5-5z"/></svg>
                </button>
                <button id="mic-btn" class="active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c1.103 0 2 .897 2 2v7c0 1.103-.897 2-2 2s-2-.897-2-2v-7c0-1.103.897-2 2-2zm0-2c-2.209 0-4 1.791-4 4v7c0 2.209 1.791 4 4 4s4-1.791 4-4v-7c0-2.209-1.791-4-4-4zm8 9v2c0 4.418-3.582 8-8 8s-8-3.582-8-8v-2h2v2c0 3.309 2.691 6 6 6s6-2.691 6-6v-2h2zm-7 13v-2h-2v2h-4v2h10v-2h-4z"/></svg>
                </button>
                <button id="screen-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 1v17h24v-17h-24zm22 15h-20v-13h20v13zm-6.599 4l2.599 3h-12l2.599-3h6.802z"/></svg>
                </button>
                <button id="leave-btn" style="background-color: #FF5050">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 10v-5l8 7-8 7v-5h-8v-4h8zm-16-8v20h14v-2h-12v-16h12v-2h-14z"/></svg>
                </button>
            </div>
            <button id="join-btn">Join Stream</button>
        </section>

        <section id="messages__container">

            <div id="messages">
                <div class="message__wrapper">
                    <div class="message__body__bot">
                        <strong class="message__author__bot">BOT</strong>
                        <p class="message__text__bot">Riunione Iniziata!</p>
                    </div>
                </div>

            </div>

            <form id="message__form">
                <input type="text" name="message" placeholder="Send a message...." />
            </form>

        </section>
    </div>
</main>

</body>

@vite(['resources/js/agora-rtm-sdk-1.5.1.js','resources/js/AgoraRTC_N-4.19.1.js', 'resources/js/room.js','resources/js/roomrtc.js'])



</html>
