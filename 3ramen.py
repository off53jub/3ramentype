

import os
from flask import Flask, request, redirect, render_template, flash
from werkzeug.utils import secure_filename
from keras.models import Sequential, load_model
from keras.preprocessing import image

import numpy as np



classes = ["醤油","味噌","塩"]
image_size = 50


UPLOAD_FOLDER = "uploads"
ALLOWED_EXTENSIONS = set(['png', 'jpg', 'jpeg', 'gif'])

app = Flask(__name__)

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

model = load_model('./3ramen.h5',compile=False)


@app.route('/', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        if 'file' not in request.files:
            flash('ファイルを入れてください')
            return redirect(request.url)
        file = request.files['file']
        if file.filename == '':
            flash('ファイルを入れてください')
            return redirect(request.url)
        if file and allowed_file(file.filename):
            filename = secure_filename(file.filename)
            file.save(os.path.join(UPLOAD_FOLDER, filename))
            filepath = os.path.join(UPLOAD_FOLDER, filename)

            
            img = image.load_img(filepath, target_size=(image_size,image_size))
            img = image.img_to_array(img)
            data = np.array([img])
          
            result = model.predict(data)[0]
            predicted = result.argmax()
            pred_answer = "これは" + classes[predicted] +'ラーメンです'

            return render_template("index.html",answer=pred_answer)

    return render_template("index.html",answer="")


if __name__ == "__main__":
    port = int(os.environ.get('PORT', 8080))
    app.run(host ='0.0.0.0',port = port)