from flask import Flask, request, jsonify
from tensorflow.keras.models import load_model
from PIL import Image
import base64
import io
import numpy as np

app = Flask(__name__)

# Load model deteksi emosi
model = load_model('emotion_model.h5')  # Pastikan model tersedia di direktori yang sama
emotion_labels = ['Happy', 'Sad', 'Angry', 'Neutral']

@app.route('/processEmotion', methods=['POST'])
def process_emotion():
    data = request.json
    image_data = data['image']

    # Decode Base64 image
    image_bytes = base64.b64decode(image_data.split(',')[1])
    image = Image.open(io.BytesIO(image_bytes)).convert('L')  # Konversi ke grayscale
    image = image.resize((48, 48))  # Ubah ukuran sesuai dengan input model
    image_array = np.array(image).reshape(1, 48, 48, 1) / 255.0

    # Prediksi emosi
    prediction = model.predict(image_array)
    emotion = emotion_labels[np.argmax(prediction)]

    return jsonify({'emotion': emotion})

if __name__ == '__main__':
    app.run(port=5000)
