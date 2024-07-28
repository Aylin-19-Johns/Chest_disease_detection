# Import necessary libraries
import tensorflow as tf
from tensorflow.keras.preprocessing import image
from tensorflow.keras.applications.imagenet_utils import preprocess_input
import numpy as np
import cv2
import sys




# Load the trained model using tf.keras.models.load_model
model_path = "trained_model_cnn.h5"
model = tf.keras.models.load_model(model_path)

# Define class names
class_name = ['bacterialpneumonia', 'corona', 'normal', 'tuberculosis', 'viralpneumonia']



# Define a function to classify the image
def classify_image(image_path):
    # Load the image
    img = cv2.imread(image_path)

    # Check if the image is loaded successfully
    if img is None:
        print("Error: Unable to load the image. Please make sure the file path is correct and the image format is supported.")
        return

    # Resize the image to match the input shape of the model
    desired_shape = (224, 224)
    resized_image = cv2.resize(img, desired_shape)

    # Convert the image to a NumPy array
    image_array = np.array(resized_image)

    # Reshape the array to match the input shape of the model
    image_array = image_array.reshape(1, 224, 224, 3)  # Assuming batch size of 1

    # Make predictions using the loaded model
    predictions = model.predict(image_array)

    # Get the predicted class index
    predicted_class_index = np.argmax(predictions, axis=1)

    # Get the predicted class label
    predicted_class = class_name[predicted_class_index[0]]

    return predicted_class


# Check if a command-line argument is provided (file path)
if len(sys.argv) > 1:
    image_path = sys.argv[1]
    # Classify the image
    predicted_class = classify_image(image_path)
    print(predicted_class)
    
    # Extract text from the image
    
else:
    print("Please provide the path to the image file as a command-line argument.")
