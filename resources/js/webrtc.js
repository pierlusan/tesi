let APP_ID ='1d9240405dfc47fd9f9cc19dcdb988e4';
    let token = null;
    let uid = String(Math.floor(Math.random() * 10000))
    let client;
    let channel;
    let queryString = window.location.search
    let urlParams = new URLSearchParams(queryString)
    let roomId = urlParams.get('inviteCode')

    if (!roomId){
        window.location.href = '/lobby1';
    }

    let localstream;
    let remotestream;
    let peerConnection;
    const servers = {
        iceServers:[{
            urls:['stun:stun.relay.metered.ca:80',]
        }]
    }
    let constrains ={
        video:true,
        audio:true
    }
    let init = async () => {

        client = await AgoraRTM.createInstance(APP_ID)
        await client.login({uid,token})

        channel = client.createChannel(roomId)
        await channel.join()
        channel.on('MemberJoined',handleUserJoined)
        channel.on("MemberLeft", handleUserLeft)

        client.on('MessageFromPeer', handleMessageFromPeer)

        localstream = await navigator.mediaDevices.getUserMedia(constrains)
        document.getElementById('user-1').srcObject = localstream


    }

    let handleUserLeft = (MemberId) => {
        document.getElementById('user-2').style.display = 'none'
    }

    let handleMessageFromPeer = async (message, MemberId) => {

        message =JSON.parse(message.text)

        if(message.type === 'offer'){
            await createAnswer(MemberId, message.offer)
        }
        if(message.type === 'answer'){
          await addAnswer(message.answer)
        }
        if(message.type === 'candidate'){
            if(peerConnection){
                peerConnection.addIceCandidate(message.candidate)
            }

        }
    }

    let handleUserJoined = async (MemberId) =>{
        console.log('A new user joined the channel:', MemberId)
        await createOffer(MemberId)

}

let createPeerConnection = async (MemberId) =>  {
    peerConnection = new RTCPeerConnection (servers)
    remotestream = new MediaStream()
    document.getElementById('user-2').srcObject = remotestream
    document.getElementById('user-2').style.display = 'block'

    if (!localstream){
        localstream = await navigator.mediaDevices.getUserMedia({video: true, audio: true})
        document.getElementById('user-1').srcObject = localstream

    }

    localstream.getTracks().forEach((track) =>{
        peerConnection.addTrack(track, localstream)
    } )

    peerConnection.ontrack = (event) =>{
        event.streams[0].getTracks().forEach((track) => {
            remotestream.addTrack(track)
        })
    }

    peerConnection.onicecandidate = async (event) =>{
        if (event.candidate){
             await client.sendMessageToPeer({
                 text: JSON.stringify({
                     'type': 'candidate',
                     'candidate': event.candidate
                 })
             }, MemberId)

        }
    }

}

let createOffer = async (MemberId) => {
    await createPeerConnection(MemberId)

    let offer = await peerConnection.createOffer()
    await peerConnection.setLocalDescription(offer)
    await client.sendMessageToPeer({text: JSON.stringify({'type': 'offer', 'offer': offer})}, MemberId)


}

let createAnswer = async (MemberId,offer)=> {
        await createPeerConnection(MemberId)

    await peerConnection.setRemoteDescription(offer)
    let answer = await peerConnection.createAnswer()
    await peerConnection.setLocalDescription(answer)
    await client.sendMessageToPeer({text: JSON.stringify({'type': 'answer', 'answer': answer})}, MemberId)



}

let addAnswer = async (answer) => {
        if(! peerConnection.currentRemoteDescription){
            peerConnection.setRemoteDescription(answer)
        }
}

let leaveChannel = async ()=>{
        await channel.leave()
        await client.leave()
}

let toggleCamera = async () =>{
    let videoTrack = localstream.getTracks().find(track => track.kind === 'video')
    if (videoTrack.enabled){
        videoTrack.enabled = false
    }
    else {
        videoTrack.enabled = true
    }
}

let toggleMic = async () =>{
    let audioTrack = localstream.getTracks().find(track => track.kind === 'audio')
    if (audioTrack.enabled){
        audioTrack.enabled = false
        document.getElementById('mic-icon').innerHTML = '<x-feathericon-mic-off class="h-4 mr-1 -ml-1" />';
    }
    else {
        audioTrack.enabled = true
        document.getElementById('mic-icon').innerHTML = '<x-feathericon-mic class="h-4 mr-1 -ml-1" />';
    }
}

window.addEventListener('beforeunload', leaveChannel)
document.getElementById('camera-btn').addEventListener('click', toggleCamera)
document.getElementById('mic-btn').addEventListener('click', toggleMic)


init()

