'use strict';
document.addEventListener('DOMContentLoaded',()=>{
 const video=document.querySelector('#camera'),start=document.querySelector('#start-camera'),take=document.querySelector('#take-photo');
 if(start)start.addEventListener('click',async()=>{try{video.srcObject=await navigator.mediaDevices.getUserMedia({video:{facingMode:'user'},audio:false});}catch(e){alert('Camera unavailable. Use HTTPS and allow camera permission.');}});
 if(take)take.addEventListener('click',()=>{if(!video.videoWidth)return alert('Start the camera first.');const c=document.querySelector('#snapshot');c.width=640;c.height=Math.round(640*video.videoHeight/video.videoWidth);c.getContext('2d').drawImage(video,0,0,c.width,c.height);document.querySelector('#camera-data').value=c.toDataURL('image/jpeg',.82);video.classList.add('captured');take.textContent='Photo captured ✓';});
 const q=document.querySelector('#qr');if(q){const draw=()=>window.QRCode?new QRCode(q,{text:q.dataset.value,width:220,height:220,colorDark:'#092c4c',colorLight:'#ffffff',correctLevel:QRCode.CorrectLevel.H}):setTimeout(draw,100);draw();}
});
