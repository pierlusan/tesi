/*const bottoneAvvio = document.getElementById('avviaFotocamera');
const bottoneDisattiva = document.getElementById('disattivaFotocamera');
const videoStream = document.getElementById('streamVideo');
let mediaStream; // Memorizza il flusso video per la disattivazione



bottoneAvvio.addEventListener('click', async () => {
    try {
        // Ottieni l'accesso alla fotocamera
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });

        // Visualizza il video dalla fotocamera nel elemento <video>
        videoStream.srcObject = stream;

        // Memorizza il flusso video per la disattivazione
        mediaStream = stream;

        // Nascondi il bottone di avvio e mostra il bottone di disattivazione
        bottoneAvvio.style.display = 'none';
        bottoneDisattiva.style.display = 'inline';
    } catch (error) {
        console.error('Errore durante l\'accesso alla fotocamera:', error);
    }
});

// Gestione del click sul bottone di disattivazione
bottoneDisattiva.addEventListener('click', () => {
    // Interrompi il flusso video e nascondi il bottone di disattivazione
    mediaStream.getTracks().forEach(track => track.stop());
    videoStream.srcObject = null;
    bottoneDisattiva.style.display = 'none';
    bottoneAvvio.style.display = 'inline';



// Ora puoi utilizzare AgoraRTM come dipendenza importata

//import AgoraRTM from './agora-rtm-sdk-1.5.1';
//import AgoraRTM from './agora-rtm-sdk-1.5.1'
//import AgoraRTM from './agora-rtm-sdk-1.5.1';

// Ora puoi accedere a tutte le funzionalità fornite da AgoraRTMSDK

import {stringify} from "postcss";

let ws = new WebSocket("ws://localhost:8895");
ws.onopen = function() {

    // Web Socket is connected, send datas to server
   // ws.send("Message from user");
    console.log("Message send to server");
};*/
//import AgoraRTM from './agora-rtm-sdk-1.5.1';
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
    }
    else {
        audioTrack.enabled = true
    }
}
window.addEventListener('beforeunload',leaveChannel)
document.getElementById('camera-btn').addEventListener('click',toggleCamera)
document.getElementById('mic-btn').addEventListener('click',toggleMic)


init()
// Creazione di un oggetto WebSocket per la connessione al server di segnalazione
/*const socket = new WebSocket('ws://localhost:8895'); // Sostituisci con l'indirizzo del tuo server

// Oggetto PeerConnection
let pc;

// Configurazione della connessione PeerConnection
const configuration = {
    iceServers: [
        { urls: 'stun:stun.l.google.com:19302' }, // Server STUN di Google
    ],
};

// Gestisce l'apertura della connessione WebSocket
socket.addEventListener('open', async (event) => {
    console.log('Connesso al server di segnalazione WebRTC');

    // Crea una connessione PeerConnection
    pc = new RTCPeerConnection(configuration);

    // Gestisce gli eventi ICE (Interactive Connectivity Establishment) per la connessione
    pc.onicecandidate = (event) => {
        if (event.candidate) {
            // Invia l'ICE candidate al server di segnalazione
            inviaMessaggioAlServer({ type: 'ice-candidate', candidate: event.candidate });
        }
    };

    // Aggiungi il tuo flusso multimediale (ad esempio, la webcam)
    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    stream.getTracks().forEach((track) => {
        pc.addTrack(track, stream);
    });

    // Crea l'offerta SDP e imposta la tua descrizione locale
    const offer = await pc.createOffer();
    await pc.setLocalDescription(offer);

    // Invia l'offerta al server di segnalazione
    inviaMessaggioAlServer({ type: 'offer', sdp: pc.localDescription });
});

// Gestisce la ricezione di messaggi dal server di segnalazione
// Gestisce la ricezione di messaggi dal server di segnalazione
socket.addEventListener('message', async (event) => {
    const message = event.data;
    console.log(message)

    // Verifica se il messaggio è una stringa
    if (typeof message === 'string') {
        try {
            const parsedMessage = JSON.parse(message);
            console.log('Messaggio JSON ricevuto dal server:', parsedMessage);

            if (parsedMessage.type === 'answer') {
                // Ricevuto un answer SDP dal server, imposta la descrizione remota
                await pc.setRemoteDescription(new RTCSessionDescription(parsedMessage.sdp));
            } else if (parsedMessage.type === 'ice-candidate') {
                // Ricevuto un ICE candidate dal server, aggiungilo alla connessione PeerConnection
                pc.addIceCandidate(new RTCIceCandidate(parsedMessage.candidate));
            }
        } catch (error) {
            console.error('Errore nel parsing del messaggio JSON:', error);
        }
    } else {
        console.error('Messaggio non è una stringa JSON:', message);
    }
});


// Invia messaggi al server di segnalazione quando necessario
function inviaMessaggioAlServer(message) {
    socket.send(JSON.stringify(message));
}

// Chiudi la connessione WebSocket quando hai finito
function chiudiConnessione() {
    socket.close();
}
*/
