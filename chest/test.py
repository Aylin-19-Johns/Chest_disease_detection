import os
import tensorflow as tf
from tensorflow.keras.preprocessing import image
from tensorflow.keras.applications.imagenet_utils import preprocess_input
import numpy as np

# Load the trained model using tf.keras.models.load_model
model_path = "densenet201.hdf5"
model = tf.keras.models.load_model(model_path)

# Function to preprocess the image
def preprocess_image(img_path):
    img = image.load_img(img_path, target_size=(224, 224))  # Adjust target_size as needed
    img_array = image.img_to_array(img)
    img_array = img_array / 255
    img_array = np.expand_dims(img_array, axis=0)
    return img_array

# Function to make predictions for a single image
def predict_image(img_path):
    img_array = preprocess_image(img_path)
    x = preprocess_input(img_array)
    predictions = model.predict(x)

    # Assuming the model has five classes
    class_labels = ["Bacterial Pneumonia", "Corona Virus Disease", "Normal", "Tuberculosis", "Viral Pneumonia"]

    # Get the predicted class labels
    predicted_classes = [class_labels[i] for i in np.argmax(predictions, axis=1)]

    # Print the result to the console
    if(predicted_classes=="Bacterial Pneumonia"):

        print(f"For image {img_path}, the predicted class is: {predicted_classes}")

# Function to predict images in a folder
def predict_images_in_folder(folder_path):
    # List all files in the folder
    file_list = os.listdir(folder_path)

    # Iterate through each file in the folder
    for file_name in file_list:
        # Construct the full path to the file
        file_path = os.path.join(folder_path, file_name)

        # Skip directories (if any)
        if os.path.isdir(file_path):
            continue


        # Process the image and make predictions
        predict_image(file_path)

# Replace "your_folder_path" with the actual path to your folder containing images
folder_path = "Lung_Disease_Dataset\\train\\Bacterial Pneumonia"
predict_images_in_folder(folder_path)
