<!DOCTYPE html>
<html>
<head>
    <script src="https://8x8.vc/vpaas-magic-cookie-783db644095d41f380bbaf8b026d0fe4/external_api.js" async></script>
    <style>
        html, body, #jaas-container { height: 100%; }
        #emotionDisplay {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
        }
    </style>
    <script type="text/javascript">
        window.onload = () => {
            // Initialize Jitsi Meet
            const api = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: "vpaas-magic-cookie-783db644095d41f380bbaf8b026d0fe4/MyCustomRoom",
                parentNode: document.querySelector('#jaas-container'),
                jwt: "eyJraWQiOiJ2cGFhcy1tYWdpYy1jb29raWUtNzgzZGI2NDQwOTVkNDFmMzgwYmJhZjhiMDI2ZDBmZTQvZGY3NDdmLVNBTVBMRV9BUFAiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJqaXRzaSIsImlzcyI6ImNoYXQiLCJpYXQiOjE3MzM5NDQ1NjMsImV4cCI6MTczMzk1MTc2MywibmJmIjoxNzMzOTQ0NTU4LCJzdWIiOiJ2cGFhcy1tYWdpYy1jb29raWUtNzgzZGI2NDQwOTVkNDFmMzgwYmJhZjhiMDI2ZDBmZTQiLCJjb250ZXh0Ijp7ImZlYXR1cmVzIjp7ImxpdmVzdHJlYW1pbmciOmZhbHNlLCJvdXRib3VuZC1jYWxsIjpmYWxzZSwic2lwLW91dGJvdW5kLWNhbGwiOmZhbHNlLCJ0cmFuc2NyaXB0aW9uIjpmYWxzZSwicmVjb3JkaW5nIjpmYWxzZX0sInVzZXIiOnsiaGlkZGVuLWZyb20tcmVjb3JkZXIiOmZhbHNlLCJtb2RlcmF0b3IiOnRydWUsIm5hbWUiOiJUZXN0IFVzZXIiLCJpZCI6Imdvb2dsZS1vYXV0aDJ8MTAyMjg4NzE1ODcyMzI0OTQ5OTk2IiwiYXZhdGFyIjoiIiwiZW1haWwiOiJ0ZXN0LnVzZXJAY29tcGFueS5jb20ifX0sInJvb20iOiIqIn0.WhzhaCuPVxMn41dic1N4SYlwi0apzaOlNM9yiNHxiiPr_aYP8ATwkbqnFnK5Fs7sryvBqyP4TvkSOHtBferN83UAW8yQLbv6cR7oKxHfoIxEW7SKSSonu4WZmYKqDlsZBKHpiGN-35NCquaYnlXf9jxEmoG21gnlw2cORzZRQ-BnxF9w3GSOtHQq73aABNjvx02nJHk1UTN-luNzxytXVyLNdiHd74BE6-04i0J-vsHeYVf4S5kHLQRRBZOU5NQCnzIBTkfZre9BtuxMHoGG7CX4wvDELeJNcJxN9YRvp1-sNehNXi3rRnBa-bP1q3VIoGNIIfgomfSwNRpiZ-P04g"
            });

           //

            const emotionDisplay = document.createElement('div');
            emotionDisplay.setAttribute('id', 'emotionDisplay');
            emotionDisplay.textContent = "Detecting emotion...";
            document.body.appendChild(emotionDisplay);

            navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
                video.srcObject = stream;

                setInterval(() => {
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const image = canvas.toDataURL('image/png');

                    fetch('/api/process-emotion', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ image })
                    })
                    .then(response => response.json())
                    .then(data => {
                        emotionDisplay.textContent = `Emotion: ${data.emotion}`;
                    })
                    .catch(err => {
                        console.error('Error detecting emotion:', err);
                    });
                }, 10000); // Ambil gambar setiap 10 detik
            });
        }
    </script>
</head>
<body>
    <div id="jaas-container"></div>
</body>
</html>
