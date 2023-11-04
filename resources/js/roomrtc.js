let messagesContainer = document.getElementById('messages');
messagesContainer.scrollTop = messagesContainer.scrollHeight;

const memberContainer = document.getElementById('members__container');
const memberButton = document.getElementById('members__button');

const chatContainer = document.getElementById('messages__container');
const chatButton = document.getElementById('chat__button');

let activeMemberContainer = false;

memberButton.addEventListener('click', () => {
    if (activeMemberContainer) {
        memberContainer.style.display = 'none';
    } else {
        memberContainer.style.display = 'block';
    }

    activeMemberContainer = !activeMemberContainer;
});

let activeChatContainer = false;

chatButton.addEventListener('click', () => {
    if (activeChatContainer) {
        chatContainer.style.display = 'none';
    } else {
        chatContainer.style.display = 'block';
    }

    activeChatContainer = !activeChatContainer;
});

let displayFrame = document.getElementById('stream__box')
let videoFrames = document.getElementsByClassName('video__container')
let userIdInDisplayFrame = null;


let expandVideoFrame = (e) => {

    let child = displayFrame.children[0]
    if(child){
        document.getElementById('streams__container').appendChild(child)
    }

    displayFrame.style.display = 'block'
    displayFrame.appendChild(e.currentTarget)
    userIdInDisplayFrame =e.currentTarget.id
    for(let i=0;videoFrames.length> i; i++){
        if (videoFrames[i].id !== userIdInDisplayFrame) {
            videoFrames[i].style.height = '100px'
            videoFrames[i].style.width = '100px'
        }

    }

}

for(let i=0;videoFrames.length> i; i++){
    videoFrames[i].addEventListener('click',expandVideoFrame)
}


let hideDisplayFrame = () =>{
    userIdInDisplayFrame = null
    displayFrame.style.display=null

    let child = displayFrame.children[0]

    document.getElementById('streams__container').appendChild(child)

    for (let i=0;videoFrames.length > i;i++){
        videoFrames[i].style.height = '300px'
        videoFrames[i].style.width = '300px'
    }


}
displayFrame.addEventListener('click',hideDisplayFrame)

const App_ID="c4e01afaa134412b85a0be9679574954"

let uid= sessionStorage.getItem('uid')
if (!uid){
    uid = String(Math.floor(Math.random() * 10000))
    sessionStorage.setItem('uid',uid)

}

let token = null;
let client;

let rtmClient;
let channel;

const queryString = window.location.search
const urlParams = new URLSearchParams(queryString)
let roomId = urlParams.get('room')
if (!roomId){
    roomId= 'main'
}
let displayname = sessionStorage.getItem('display_name')

if(!displayname){
    window.location.href =  `/`
}

let localTracks = []
let remoteUsers = {}

let localScreenTracks;
let sharingScreen = false;

let joinRoomInit = async () =>{

    rtmClient = await AgoraRTM.createInstance(App_ID)
    await rtmClient.login({uid,token})

    await rtmClient.addOrUpdateLocalUserAttributes({'name':displayname})
    channel = await rtmClient.createChannel(roomId)
    await channel.join()
    channel.on('MemberJoined', handleMemberJoin)
    channel.on('MemberLeft', handleMemberLeft)
    channel.on('ChannelMessage', handleChannelMessage)


    getMembers()
    //addBotMessageToDom(`Ciao!  ${displayname}👋`)




    client = AgoraRTC.createClient({mode:'rtc',codec:'vp8'})
     await client.join(App_ID,roomId,token,uid)
    client.on('user-published', handleUserPublished)
    client.on('user-left', handleUserLeft)


}

let joinStream = async () => {

    document.getElementById('join-btn').style.display = 'none'
    document.getElementsByClassName('stream__actions')[0].style.display = 'flex'
    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks()

    let player=`<div class="video__container" id="user-container-${uid}">
                <div class="video-player" id="user-${uid}"></div>
            </div>`

    document.getElementById('streams__container').insertAdjacentHTML('beforeend',player)
    document.getElementById(`user-container-${uid}`).addEventListener('click',expandVideoFrame)
    localTracks[1].play(`user-${uid}`)
    await client.publish([localTracks[0],localTracks[1]])

}

let switchToCamera = async ()=>{
    let player=`<div class="video__container" id="user-container-${uid}">
                <div class="video-player" id="user-${uid}"></div>
            </div>`
    displayFrame.insertAdjacentHTML('beforeend',player)
    await localTracks[0].setMuted(true)
    await localTracks[1].setMuted(true)

    document.getElementById('mic-btn').classList.remove('active')
    document.getElementById('screen-btn').classList.remove('active')

    localTracks[1].play(`user-${uid}`)
    await client.publish([localTracks[1]])




}
let handleUserPublished = async (user, mediaType) =>{

    remoteUsers[user.uid] = user

    await client.subscribe(user, mediaType)
    let player = document.getElementById(`user-container-${user.uid}`)
    if (player === null){
        player =`<div class="video__container" id="user-container-${user.uid}">
                <div class="video-player" id="user-${user.uid}"></div>
            </div>`
        document.getElementById('streams__container').insertAdjacentHTML('beforeend', player)
        document.getElementById(`user-container-${user.uid}`).addEventListener('click',expandVideoFrame)

    }
    if (displayFrame.style.display){
        let videoFrame = document.getElementById(`user-container-${user.uid}`)
        videoFrame.style.height ='100px'
        videoFrame.style.width ='100px'
    }
  //  document.getElementById('streams__container').insertAdjacentHTML('beforeend', player)
    if (mediaType === 'video'){
        user.videoTrack.play(`user-${user.uid}`)
    }
    if (mediaType === 'audio'){
        user.audioTrack.play()
    }

}

let handleUserLeft = async (user)=>{
    delete remoteUsers[user.uid]

    let item = document.getElementById(`user-container-${user.uid}`)
    if(item){
        item.remove()
    }
    if (userIdInDisplayFrame === `user-container-${user.uid}`){
        displayFrame.style.display = null
        let videoFrames = document.getElementsByClassName('video__container')

        for (let i=0;videoFrames.length > i;i++){
            videoFrames[i].style.height = '300px'
            videoFrames[i].style.width = '300px'


        }

    }

}

let toggleCamera =async (e) =>{
    let button = e.currentTarget

    if (localTracks[1].muted){
        await localTracks[1].setMuted(false)
        button.classList.add('active')
    }else{
        await localTracks[1].setMuted(true)
        button.classList.remove('active')
    }

}

let toggleMic =async (e) =>{
    let button = e.currentTarget

    if (localTracks[0].muted){
        await localTracks[0].setMuted(false)
        button.classList.add('active')
    }else{
        await localTracks[0].setMuted(true)
        button.classList.remove('active')
    }

}

let toggleScreen = async (e) => {
    let screenButton = e.currentTarget
    let cameraButton = document.getElementById('camera-btn')
    try {
        if (!sharingScreen){



            localScreenTracks = await AgoraRTC.createScreenVideoTrack()

            console.log('kkk')

            localScreenTracks = await AgoraRTC.createScreenVideoTrack()
            sharingScreen = true
            screenButton.classList.add('active')
            cameraButton.classList.remove('active')
            cameraButton.style.display = 'none'

            document.getElementById(`user-container-${uid}`).remove()
            displayFrame.style.display ='block'
            let player = `<div class="video__container" id="user-container-${uid}">
                <div class="video-player" id="user-${uid}"></div>
            </div>`
            displayFrame.insertAdjacentHTML('beforeend',player)
            document.getElementById(`user-container-${uid}`).addEventListener('click', expandVideoFrame)

            userIdInDisplayFrame = `user-container-${uid}`
            localScreenTracks.play(`user-${uid}`)

            await client.unpublish([localTracks[1]])
            await client.publish([localScreenTracks ])

            let videoFrames = document.getElementsByClassName('video__container')
            for(let i=0;videoFrames.length> i; i++){
                if (videoFrames[i].id !== userIdInDisplayFrame) {
                    videoFrames[i].style.height = '100px'
                    videoFrames[i].style.width = '100px'
                }

            }


        }else{
            sharingScreen = false
            cameraButton.style.display= 'block'
            document.getElementById(`user-container-${uid}`).remove()

            await client.unpublish([localScreenTracks])
            switchToCamera()

    }


    }catch (error){
        if (error.name === 'AgoraRTCException' && error.code === 'PERMISSION_DENIED') {
            const risposta = confirm("Per condividere lo schermo, è necessario concedere il permesso. Vuoi riprovare?");
            if (risposta) {
                // L'utente ha scelto di riprovare
                toggleScreen();
            }
        } else {
            // Gestisci altri errori
            console.error("Si è verificato un errore durante la condivisione dello schermo:", error);
        }
    }

}

let leaveStream = async (e) => {
    e.preventDefault()
    document.getElementById('join-btn').style.display = 'block'
    document.getElementsByClassName('stream__actions')[0].style.display = 'none'

    for (let i = 0;localTracks.length > i; i++){
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.unpublish([localTracks[0],localTracks[1]])

    if (localScreenTracks){
        await client.unpublish([localScreenTracks])
    }
    document.getElementById(`user-container-${uid}`).remove()
    if (userIdInDisplayFrame === `user-container-${uid}` ){
        displayFrame.style.display = null
        for (let i=0;videoFrames.length > i;i++){
            videoFrames[i].style.height = '300px'
            videoFrames[i].style.width = '300px'
        }
    }
    channel.sendMessage({text:JSON.stringify({'type':'user_left','uid':uid})})


}
document.getElementById('camera-btn').addEventListener('click',toggleCamera)
document.getElementById('mic-btn').addEventListener('click',toggleMic)
document.getElementById('screen-btn').addEventListener('click',toggleScreen)
document.getElementById('join-btn').addEventListener('click',joinStream)
document.getElementById('leave-btn').addEventListener('click',leaveStream)




////  PARTE DEL CODICE CHE SI OCCUPA DI RTM

let handleMemberJoin = async (MemberId) => {
    console.log('New user', MemberId)
    addMemberToDom(MemberId)
    let members = await channel.getMembers()
    updateMemberTotal(members)
    let {name} =await rtmClient.getUserAttributesByKeys(MemberId,['name'])

   // addBotMessageToDom(`Ciao!  ${name}!👋`)

}
let addMemberToDom = async (MemberId) => {

    let {name} =await rtmClient.getUserAttributesByKeys(MemberId,['name'])
    let membersWrapper = document.getElementById('member__list')
    let memberItem = `<div class="member__wrapper" id="member__${MemberId}__wrapper">
                    <span class="green__icon"></span>
                    <p class="member_name">${name}</p>
                </div>`

    membersWrapper.insertAdjacentHTML('beforeend',memberItem)

}

let updateMemberTotal = async (members) => {
    let total = document.getElementById('members__count')
    total.innerText = members.length

}
let handleMemberLeft = async (MemberId) =>{
    removeMemberFromDom(MemberId)
    let members = await channel.getMembers()
    updateMemberTotal(members)


}

let removeMemberFromDom =async (MemberId) =>{
    let memberWrapper = document.getElementById(`member__${MemberId}__wrapper`)
    let name = memberWrapper.getElementsByClassName('member_name')[0].textContent
    memberWrapper.remove()
    //addBotMessageToDom(` ${name} è fuori dalla riunione`)

}

let getMembers = async () =>{
    let members = await channel.getMembers()
    updateMemberTotal(members)

    for(let i = 0; members.length >i; i++){
        addMemberToDom(members[i])
    }
}

let handleChannelMessage = async (messageData, MemberId) => {
    console.log('A new message was recived')
    let data = JSON.parse(messageData.text)

    if (data.type === 'chat'){
        addMessageToDom(data.displayName,data.message)
    }
    if (data.type === 'user_left'){
        document.getElementById(`user-container-${data.uid}`).remove()
        if (userIdInDisplayFrame === `user-container-${uid}` ){
            displayFrame.style.display = null
            for (let i=0;videoFrames.length > i;i++){
                videoFrames[i].style.height = '300px'
                videoFrames[i].style.width = '300px'
            }
        }
    }
}

let sendMessage = async (e) =>{
    e.preventDefault()

    let message = e.target.message.value
    channel.sendMessage({text:JSON.stringify(({'type':'chat','message':message,'displayName':displayname}))})
    addMessageToDom(displayname,message)
    e.target.reset()


}

let addMessageToDom = (name, message) =>  {
    let messagesWrapper = document.getElementById('messages')

    let newMessage = `<div class="message__wrapper">
                    <div class="message__body__bot">
                        <strong class="message__author__bot">${name}</strong>
                        <p class="message__text__bot">${message}</p>
                    </div>
                </div>`

    messagesWrapper.insertAdjacentHTML('beforeend',newMessage)
    let lastMesage = document.querySelector('#messages .message__wrapper:last-child')
    if(lastMesage){
        lastMesage.scrollIntoView()
    }

}

let addBotMessageToDom = (botMessage) =>  {
    let messagesWrapper = document.getElementById('messages')

    let newMessage = `<div class="message__wrapper">
                    <div class="message__body__bot">
                        <strong class="message__author__bot">🤖 Mumble Bot</strong>
                        <p class="message__text__bot">${botMessage}</p>
                    </div>
                </div>`

    messagesWrapper.insertAdjacentHTML('beforeend',newMessage)
    let lastMesage = document.querySelector('#messages .message__wrapper:last-child')
    if(lastMesage){
        lastMesage.scrollIntoView()
    }

}


let leaveChannel = async () =>{
    await channel.leave()
    await rtmClient.logout()
    sessionStorage.removeItem('display_name')
}

window.addEventListener('beforeunload', leaveChannel)
let messageForm = document.getElementById('message__form')
messageForm.addEventListener('submit',sendMessage)


joinRoomInit()



